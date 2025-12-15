<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\BukuTamuController;
use App\Http\Controllers\InspeksiUpsController;
use App\Http\Controllers\InspeksiStavoltController;
use App\Http\Controllers\InspeksiMonitorController;
use App\Http\Controllers\InspeksiProyektorController;
use App\Http\Controllers\KaryawanController;

//inventaris
Route::resource('inventaris', InventarisController::class);
Route::get('inventaris-report', [InventarisController::class, 'report'])->name('inventaris.report');

//Karyawan
Route::resource('karyawan', KaryawanController::class);
Route::get('karyawan-export', [KaryawanController::class, 'exportExcel'])->name('karyawan.export');


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
Route::get('bukutamu-export-excel', [BukuTamuController::class, 'exportExcel'])->name('bukutamu.export.excel');
Route::get('bukutamu-export-pdf', [BukuTamuController::class, 'exportPDF'])->name('bukutamu.export.pdf');


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

    $role = Auth::user()->name;

    if ($role === 'USER') {
        return redirect()->route('bukutamu.index'); // USER diarahkan ke Buku Tamu
    }

    // Jika role ICT, tetap gunakan Controller
    return app(DashboardController::class)->index();

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
