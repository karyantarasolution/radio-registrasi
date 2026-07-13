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

// Inventaris
Route::get('inventaris-report', [InventarisController::class, 'report'])
    ->name('inventaris.report');
Route::patch('inventaris/{inventaris}/verifikasi', [InventarisController::class, 'verifikasi'])
    ->name('inventaris.verifikasi');
Route::patch('inventaris/{inventaris}/peminjaman', [InventarisController::class, 'updatePeminjaman'])
    ->name('inventaris.peminjaman');

Route::resource('inventaris', InventarisController::class)
    ->except(['show']);

// Gudang IT
Route::resource('gudang-barang', GudangBarangController::class)->except(['show']);
Route::get('gudang-laporan', [GudangBarangController::class, 'laporan'])->name('gudang.laporan');
Route::get('gudang-laporan/maintenance', [GudangBarangController::class, 'previewMaintenance'])->name('gudang.preview.maintenance');
Route::get('gudang-laporan/barang-baru', [GudangBarangController::class, 'previewBaru'])->name('gudang.preview.baru');
Route::get('gudang-laporan/mutasi', [GudangBarangController::class, 'previewMutasi'])->name('gudang.preview.mutasi');
Route::get('gudang-laporan/maintenance/report', [GudangBarangController::class, 'reportMaintenance'])->name('gudang.report.maintenance');
Route::get('gudang-laporan/barang-baru/report', [GudangBarangController::class, 'reportBaru'])->name('gudang.report.baru');
Route::get('gudang-laporan/mutasi/report', [GudangBarangController::class, 'reportMutasi'])->name('gudang.report.mutasi');





//Karyawan
Route::resource('karyawan', KaryawanController::class);
Route::get('karyawan-export', [KaryawanController::class, 'exportExcel'])->name('karyawan.export');
Route::get('karyawan-export-pdf', [KaryawanController::class, 'exportPDF'])->name('karyawan.export.pdf');
Route::get('karyawan/{id}/report', [KaryawanController::class, 'report'])->name('karyawan.report');


//Proyektor
Route::resource('inspeksiproyektor', InspeksiProyektorController::class);
Route::get('inspeksiproyektor/export/excel', [InspeksiProyektorController::class, 'exportExcel'])->name('inspeksiproyektor.export.excel');
Route::get('inspeksiproyektor/{id}/report', [InspeksiProyektorController::class, 'report'])->name('inspeksiproyektor.report');

//Monitor
Route::resource('inspeksimonitor', InspeksiMonitorController::class);

// route untuk cetak per data (pdf)
Route::get('inspeksimonitor/{id}/report', [InspeksiMonitorController::class, 'report'])
    ->name('inspeksimonitor.report');
Route::get('inspeksimonitor/export-excel', [InspeksiMonitorController::class, 'exportExcel'])->name('inspeksimonitor.export.excel');

//Stavolt
Route::resource('inspeksistavolt', InspeksiStavoltController::class);
Route::get('inspeksistavolt-export-excel', [InspeksiStavoltController::class, 'exportExcel'])->name('inspeksistavolt.export.excel');
Route::get('inspeksistavolt-export-pdf', [InspeksiStavoltController::class, 'exportPDF'])->name('inspeksistavolt.export.pdf');
// per-data PDF (already available via controller.report route if you set it)
Route::get('inspeksistavolt/{inspeksistavolt}/report', [InspeksiStavoltController::class, 'report'])->name('inspeksistavolt.report');




//UPS
Route::resource('inspeksiups', InspeksiUpsController::class);
// Tambahkan route khusus untuk export
Route::get('inspeksiups-export-excel', [InspeksiUpsController::class, 'exportExcel'])->name('inspeksiups.export.excel');
Route::get('inspeksiups-export-pdf', [InspeksiUpsController::class, 'exportPDF'])->name('inspeksiups.export.pdf');
Route::get('inspeksiups/{id}/report', [App\Http\Controllers\InspeksiUpsController::class, 'report'])
    ->name('inspeksiups.report');




//BUKUTAMU
Route::resource('bukutamu', BukuTamuController::class);
Route::get('bukutamu-laporan', [BukuTamuController::class, 'previewReport'])->name('bukutamu.report.preview');
Route::get('bukutamu-export-excel', [BukuTamuController::class, 'exportExcel'])->name('bukutamu.export.excel');
Route::get('bukutamu-export-pdf', [BukuTamuController::class, 'exportPDF'])->name('bukutamu.export.pdf');
Route::get('bukutamu-download-pdf', [BukuTamuController::class, 'downloadPDF'])->name('bukutamu.export.pdf.download');



//registrasi
Route::get('/registrasi/{id}/edit', [RegistrasiController::class, 'edit'])->name('registrasi.edit');
Route::put('/registrasi/{id}', [RegistrasiController::class, 'update'])->name('registrasi.update');
Route::delete('/registrasi/{id}', [RegistrasiController::class, 'destroy'])->name('registrasi.destroy');

/*
|--------------------------------------------------------------------------
| Export Routes
|--------------------------------------------------------------------------
*/
// Export semua data
Route::get('registrasi/export/all-excel', [RegistrasiController::class, 'exportAllExcel'])
    ->name('registrasi.export.all');

// Export per ID (Excel & CSV)
Route::get('registrasi/{id}/export-excel', [RegistrasiController::class, 'exportExcel'])
    ->name('registrasi.export.excel.single');
Route::get('registrasi/{id}/export-csv', [RegistrasiController::class, 'exportCSV'])
    ->name('registrasi.export.csv.single');

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/'); // arahkan ke halaman login atau home
})->name('logout');

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/dashboard/perusahaan', [DashboardController::class, 'perusahaan'])->name('dashboard.perusahaan');
Route::get('/dashboard/k3', [DashboardController::class, 'k3'])->name('dashboard.k3');

/*
|--------------------------------------------------------------------------
| Registrasi Radio
|--------------------------------------------------------------------------
*/
Route::prefix('registrasi')->name('registrasi.')->group(function () {
    Route::get('/', [RegistrasiController::class, 'index'])->name('index');
    Route::get('/create', [RegistrasiController::class, 'create'])->name('create');
    Route::post('/', [RegistrasiController::class, 'store'])->name('store');
    Route::get('/{id}/report', [RegistrasiController::class, 'report'])->name('report');
});


Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', function () {

    $role = Auth::user()->role;

    if ($role === 'user') {
        return redirect()->route('bukutamu.index');
    }

    return app(DashboardController::class)->index();
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
});

require __DIR__.'/auth.php';
