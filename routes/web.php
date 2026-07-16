<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\GudangBarangController;
use App\Http\Controllers\BukuTamuController;
use App\Http\Controllers\InspeksiUpsController;
use App\Http\Controllers\InspeksiStavoltController;
use App\Http\Controllers\InspeksiMonitorController;
use App\Http\Controllers\InspeksiProyektorController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PengajuanController;

/*
|--------------------------------------------------------------------------
| Portal & Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => redirect()->route('portal'));
Route::get('/portal', fn() => view('portal'))->name('portal');

Route::get('/login/admin', fn() => view('auth.login-admin'))->name('login.admin');
Route::get('/login/pimpinan', fn() => view('auth.login-pimpinan'))->name('login.pimpinan');
Route::get('/login/inventaris', function () {
    return view('auth.login-inventaris');
})->name('login.inventaris');

Route::get('/register/inventaris', function () {
    return view('auth.register-inventaris');
})->name('register.inventaris');

Route::post('/register/inventaris', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'nrp' => 'required|string|unique:users,nrp',
        'jabatan' => 'required|string|max:255',
        'password' => 'required|string|min:6|confirmed',
    ]);

    \App\Models\User::create([
        'name' => $request->name,
        'nrp' => $request->nrp,
        'role' => 'karyawan',
        'is_approved' => false,
        'password' => \Illuminate\Support\Facades\Hash::make($request->password),
    ]);

    return redirect()->route('login.inventaris')->with('success', 'Pendaftaran berhasil! Silakan tunggu persetujuan admin sebelum bisa login.');
})->name('register.inventaris.post');

Route::post('/login/inventaris', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'nrp' => 'required|exists:users,nrp',
        'password' => 'required',
    ]);

    $user = \App\Models\User::where('nrp', $request->nrp)->first();

    if ($user && $user->isKaryawan() && !$user->is_approved) {
        return back()->withErrors(['nrp' => 'Akun Anda belum disetujui oleh admin.'])->withInput();
    }

    if (!Auth::attempt(['name' => $user->name, 'password' => $request->password])) {
        return back()->withErrors(['password' => 'Kata sandi salah.'])->withInput();
    }

    $request->session()->regenerate();
    return redirect()->route('inventaris.index');
})->name('login.inventaris.post');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'name' => 'required|string',
        'password' => 'required',
        'login_type' => 'required|string',
    ]);

    if (!Auth::attempt($request->only('name', 'password'))) {
        return back()->withErrors(['name' => 'Nama atau kata sandi salah.'])->withInput();
    }

    $user = Auth::user();
    $loginType = $request->login_type;

    if ($loginType === 'admin_ict' && !$user->isAdmin()) {
        Auth::logout();
        return back()->withErrors(['name' => 'Akun ini bukan Admin ICT.'])->withInput();
    }

    if ($loginType === 'pimpinan' && !$user->isPimpinan()) {
        Auth::logout();
        return back()->withErrors(['name' => 'Akun ini bukan Pimpinan.'])->withInput();
    }

    $request->session()->regenerate();

    if ($user->isAdmin()) {
        return redirect()->route('dashboard');
    }
    if ($user->isPimpinan()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('dashboard');
})->name('login.post');

Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('portal');
})->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        $role = Auth::user()->role;
        if ($role === 'karyawan') {
            return redirect()->route('inventaris.index');
        }
        if ($role === 'tamu') {
            return redirect()->route('bukutamu.index');
        }
        return app(DashboardController::class)->index();
    })->name('dashboard');

    Route::get('/dashboard/perusahaan', [DashboardController::class, 'perusahaan'])->name('dashboard.perusahaan');
    Route::get('/dashboard/k3', [DashboardController::class, 'k3'])->name('dashboard.k3');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notifications
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');

    // Pengajuan - Admin ICT & Pimpinan & Karyawan
    Route::get('pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');
    Route::get('pengajuan/create', [PengajuanController::class, 'create'])->name('pengajuan.create');
    Route::post('pengajuan', [PengajuanController::class, 'store'])->name('pengajuan.store');
    Route::post('pengajuan/{id}/approve', [PengajuanController::class, 'approve'])->name('pengajuan.approve');
    Route::delete('pengajuan/{id}', [PengajuanController::class, 'destroy'])->name('pengajuan.destroy');

    // Inventaris - All authenticated users
    Route::resource('inventaris', InventarisController::class)->except(['show']);
    Route::get('inventaris/search-karyawan', [InventarisController::class, 'searchKaryawan'])->name('inventaris.search-karyawan');
    Route::patch('inventaris/{inventaris}/verifikasi', [InventarisController::class, 'verifikasi'])->name('inventaris.verifikasi');
    Route::patch('inventaris/{inventaris}/persetujuan', [InventarisController::class, 'persetujuan'])->name('inventaris.persetujuan');
    Route::patch('inventaris/{inventaris}/pengembalian', [InventarisController::class, 'pengembalian'])->name('inventaris.pengembalian');
    Route::get('inventaris-report', [InventarisController::class, 'report'])->name('inventaris.report');
    Route::get('inventaris-riwayat', [InventarisController::class, 'riwayat'])->name('inventaris.riwayat');

    // Daftar Akun Inventaris - Admin only
    Route::get('admin/daftar-akun', [InventarisController::class, 'daftarAkun'])->name('admin.daftar-akun');
    Route::post('admin/daftar-akun/{id}/approve', [InventarisController::class, 'approveAkun'])->name('admin.approve-akun');
    Route::delete('admin/daftar-akun/{id}', [InventarisController::class, 'destroyAkun'])->name('admin.destroy-akun');

    // Gudang IT
    Route::resource('gudang-barang', GudangBarangController::class)->except(['show']);
    Route::get('gudang-laporan', [GudangBarangController::class, 'laporan'])->name('gudang.laporan');
    Route::get('gudang-laporan/maintenance', [GudangBarangController::class, 'previewMaintenance'])->name('gudang.preview.maintenance');
    Route::get('gudang-laporan/barang-baru', [GudangBarangController::class, 'previewBaru'])->name('gudang.preview.baru');
    Route::get('gudang-laporan/mutasi', [GudangBarangController::class, 'previewMutasi'])->name('gudang.preview.mutasi');
    Route::get('gudang-laporan/maintenance/report', [GudangBarangController::class, 'reportMaintenance'])->name('gudang.report.maintenance');
    Route::get('gudang-laporan/barang-baru/report', [GudangBarangController::class, 'reportBaru'])->name('gudang.report.baru');
    Route::get('gudang-laporan/mutasi/report', [GudangBarangController::class, 'reportMutasi'])->name('gudang.report.mutasi');

    // Karyawan - Admin only
    Route::resource('karyawan', KaryawanController::class);
    Route::get('karyawan-export', [KaryawanController::class, 'exportExcel'])->name('karyawan.export');
    Route::get('karyawan-export-pdf', [KaryawanController::class, 'exportPDF'])->name('karyawan.export.pdf');
    Route::get('karyawan/{id}/report', [KaryawanController::class, 'report'])->name('karyawan.report');

    // Registrasi Radio
    Route::get('/registrasi/{id}/edit', [RegistrasiController::class, 'edit'])->name('registrasi.edit');
    Route::put('/registrasi/{id}', [RegistrasiController::class, 'update'])->name('registrasi.update');
    Route::delete('/registrasi/{id}', [RegistrasiController::class, 'destroy'])->name('registrasi.destroy');
    Route::get('registrasi/export/all-excel', [RegistrasiController::class, 'exportAllExcel'])->name('registrasi.export.all');
    Route::get('registrasi/{id}/export-excel', [RegistrasiController::class, 'exportExcel'])->name('registrasi.export.excel.single');
    Route::get('registrasi/{id}/export-csv', [RegistrasiController::class, 'exportCSV'])->name('registrasi.export.csv.single');
    Route::prefix('registrasi')->name('registrasi.')->group(function () {
        Route::get('/', [RegistrasiController::class, 'index'])->name('index');
        Route::get('/create', [RegistrasiController::class, 'create'])->name('create');
        Route::post('/', [RegistrasiController::class, 'store'])->name('store');
        Route::get('/{id}/report', [RegistrasiController::class, 'report'])->name('report');
    });

    // Buku Tamu
    Route::resource('bukutamu', BukuTamuController::class);
    Route::get('bukutamu-laporan', [BukuTamuController::class, 'previewReport'])->name('bukutamu.report.preview');
    Route::get('bukutamu-export-excel', [BukuTamuController::class, 'exportExcel'])->name('bukutamu.export.excel');
    Route::get('bukutamu-export-pdf', [BukuTamuController::class, 'exportPDF'])->name('bukutamu.export.pdf');
    Route::get('bukutamu-download-pdf', [BukuTamuController::class, 'downloadPDF'])->name('bukutamu.export.pdf.download');

    // Inspeksi
    Route::resource('inspeksiups', InspeksiUpsController::class);
    Route::get('inspeksiups-export-excel', [InspeksiUpsController::class, 'exportExcel'])->name('inspeksiups.export.excel');
    Route::get('inspeksiups-export-pdf', [InspeksiUpsController::class, 'exportPDF'])->name('inspeksiups.export.pdf');
    Route::get('inspeksiups/{id}/report', [InspeksiUpsController::class, 'report'])->name('inspeksiups.report');

    Route::resource('inspeksistavolt', InspeksiStavoltController::class);
    Route::get('inspeksistavolt-export-excel', [InspeksiStavoltController::class, 'exportExcel'])->name('inspeksistavolt.export.excel');
    Route::get('inspeksistavolt-export-pdf', [InspeksiStavoltController::class, 'exportPDF'])->name('inspeksistavolt.export.pdf');
    Route::get('inspeksistavolt/{inspeksistavolt}/report', [InspeksiStavoltController::class, 'report'])->name('inspeksistavolt.report');

    Route::resource('inspeksimonitor', InspeksiMonitorController::class);
    Route::get('inspeksimonitor/{id}/report', [InspeksiMonitorController::class, 'report'])->name('inspeksimonitor.report');
    Route::get('inspeksimonitor/export-excel', [InspeksiMonitorController::class, 'exportExcel'])->name('inspeksimonitor.export.excel');

    Route::resource('inspeksiproyektor', InspeksiProyektorController::class);
    Route::get('inspeksiproyektor/export/excel', [InspeksiProyektorController::class, 'exportExcel'])->name('inspeksiproyektor.export.excel');
    Route::get('inspeksiproyektor/{id}/report', [InspeksiProyektorController::class, 'report'])->name('inspeksiproyektor.report');
});

require __DIR__.'/auth.php';
