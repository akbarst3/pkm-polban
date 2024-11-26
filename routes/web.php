<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Operator\AuthController as AuthOperator;
use App\Http\Controllers\Operator\OperatorController as Operator;

use App\Http\Controllers\Pengusul\AuthController as AuthPengusul;
use App\Http\Controllers\Pengusul\PengusulController as Pengusul;
use App\Http\Controllers\Pengusul\PelaksanaanController as Pelaksanaan;

use App\Http\Controllers\Pimpinan\AuthController as AuthPimpinan;
use App\Http\Controllers\Pimpinan\PimpinanController as Pimpinan;


use App\Http\Controllers\Dospem\AuthController as AuthDospem;
use App\Http\Controllers\Dospem\DospemController as Dospem;

Route::get('/', function () {
    return view('welcome');
});

// Route untuk Operator
Route::prefix('operator')->name('operator.')->group(function () {

    Route::middleware(['auth:operator', 'session.timeout'])->group(function () {
        Route::get('/dashboard', [Operator::class, 'index'])->name('dashboard');
        Route::post('/dashboard', [Operator::class, 'storeFile'])->name('file');

        Route::middleware(['cek.surat'])->group(function () {
            Route::get('/usulan-baru', [Operator::class, 'index2'])->name('usulan.baru');
            Route::get('/usulan-baru/{nim}', [Operator::class, 'viewData'])->name('usulan.baru.nim');
            Route::delete('/usulan-baru/{id}', [Operator::class, 'deleteData'])->name('usulan.baru.delete');
            Route::get('/identitas-usulan', [Operator::class, 'index1'])->name('identitas.usulan');
            Route::post('/identitas-usulan/store', [Operator::class, 'storeData'])->name('identitas-usulan.store');
            Route::post('/identitas-usulan/find', [Operator::class, 'findDosen'])->name('identitas.usulan.find');
            Route::view('/usulan-didanai', 'operator.usulan-didanai')->name('usulan.didanai');
            Route::view('/usulan-reviewer', 'operator.usulanReviewer')->name('usulan.reviewer');
            Route::get('/identitas-reviewer', [Operator::class, 'index2'])->name('identitas.reviewer');
            Route::post('/logout', [AuthOperator::class, 'logout'])->name('logout');
        });
    });

    Route::middleware(['guest:operator'])->group(function () {
        Route::get('/login', [AuthOperator::class, 'create'])->name('login');
        Route::post('/login', [AuthOperator::class, 'login']);
    });
});

// Route untuk Pengusul
Route::prefix('pengusul')->name('pengusul.')->group(function () {
    Route::middleware('guest:pengusul')->group(function () {
        Route::get('/login', [AuthPengusul::class, 'create'])->name('login');
        Route::post('/login', [AuthPengusul::class, 'login']);
    });

    Route::middleware(['auth:pengusul', 'session.timeout'])->group(function () {
        Route::get('/dashboard', [Pengusul::class, 'createDashboard'])->name('dashboard');
        Route::get('/identitas-usulan', [Pengusul::class, 'showData'])->name('identitas-usulan');
        Route::get('/edit-usulan', [Pengusul::class, 'showDetail'])->name('edit-usulan');
        Route::patch('/edit-usulan/edit-mhs/{id}', [Pengusul::class, 'editMhs'])->name('edit-usulan.edit-mhs');
        Route::get('/identitas-usulan/pengesahan', [Pengusul::class, 'createPengesahan'])->name('identitas-usulan.pengesahan');
        Route::post('/identitas-usulan/pengesahan', [Pengusul::class, 'storePengesahan']);
        Route::patch('/edit-usulan/edit-pkm/{id}', [Pengusul::class, 'editPkm'])->name('edit-usulan.edit-pkm');
        Route::get('/edit-usulan/tambah-anggota', [Pengusul::class, 'tambahAnggota'])->name('edit-usulan.tambah-anggota');
        Route::post('/edit-usulan/tambah-anggota', [Pengusul::class, 'storeAnggota']);
        Route::get('/edit-usulan/edit-anggota/{id}', [Pengusul::class, 'createEditAnggota'])->name('edit-usulan.edit-anggota');
        Route::put('/edit-usulan/edit-anggota/{id}', [Pengusul::class, 'editAnggota']);
        Route::delete('/edit-usulan/hapus-anggota/{id}', [Pengusul::class, 'destroyAnggota'])->name('edit-usulan.hapus-anggota');
        Route::get('/identitas-usulan/proposal', [Pengusul::class, 'createProposal'])->name("identitas-usulan.proposal");
        Route::patch('/identitas-usulan/proposal', [Pengusul::class, "storeProposal"]);
        Route::get('/pengusul/identitas-usulan/download-proposal', [Pengusul::class, 'downloadProposal'])->name('identitas-usulan.download-proposal');
        Route::post('/logout', [AuthPengusul::class, 'logout'])->name('logout');
        Route::get('/pelaksanaan/dashboard-pelaksanaan', [Pelaksanaan::class, 'createDashboard'])->name('dashboard-pelaksanaan');
        Route::get('/pelaksanaan/lap-kemajuan', [Pelaksanaan::class, 'kemajuan'])->name('lap-kemajuan');
        Route::post('/pelaksanaan/lap-kemajuan/upload-file', [Pelaksanaan::class, 'uploadFile'])->name('lap-kemajuan.uploadFile');
        Route::get('/pelaksanaan/lap-kemajuan/download-file/{id}', [Pelaksanaan::class, 'downloadFile'])->name('lap-kemajuan.downloadFile');
        Route::get('/pelaksanaan/dashboard-logbook-keuangan', [Pelaksanaan::class, 'dashboardLogbookKeuangan'])->name('dashboard-logbook-keuangan');
        Route::get('/pelaksanaan/form-tambah-logbook-keuangan', [Pelaksanaan::class, 'formTambahLogbookKeuangan'])->name('form-tambah-logbook-keuangan');
        Route::post('/pelaksanaan/store-logbook-keuangan', [Pelaksanaan::class, 'storeLogbookKeuangan'])->name('store-logbook-keuangan');
        Route::get('/pelaksanaan/download-bukti/{id}', [Pelaksanaan::class, 'downloadBukti'])->name('download-bukti');
        Route::delete('/pelaksanaan/hapus-logbook-keuangan/{id}', [Pelaksanaan::class, 'hapusLogbookKeuangan'])->name('hapus-logbook-keuangan');
        Route::get('/pelaksanaan/edit-logbook-keuangan/{id}', [Pelaksanaan::class, 'editLogbookKeuangan'])->name('edit-logbook-keuangan');
        Route::put('/pelaksanaan/update-logbook-keuangan/{id}', [Pelaksanaan::class, 'updateLogbookKeuangan'])->name('update-logbook-keuangan');
        Route::get('/pelaksanaan/laporan-akhir', [Pelaksanaan::class, 'createLaporanAkhir'])->name('laporan-akhir');
        Route::patch('/pelaksanaan/upload-lapkhir', [Pelaksanaan::class, 'storeFile'])->name('upload-lapkhir');
        Route::get('/pelaksanaan/laporan-akhir/download-lapkhir/{id}', [Pelaksanaan::class, 'downloadLapkhir'])->name('laporan-akhir.downloadLapkhir');
    });
});

// Route untuk Dospem
Route::prefix('dosen-pendamping')->name('dosen-pendamping.')->group(function () {

    Route::middleware('guest:dospem')->group(function () {
        Route::get('/login', [AuthDospem::class, 'create'])->name('login');
        Route::post('/login', [AuthDospem::class, 'login']);
    });

    Route::middleware(['auth:dospem', 'session.timeout'])->group(function () {
        Route::get('/dashboard', [Dospem::class, 'index'])->name('dashboard');
        Route::get('/proposal', [Dospem::class, 'showData'])->name('proposal');
        Route::get('/proposal/show/{filename}', [Dospem::class, 'showProposal'])
            ->where('filename', '.*')
            ->name('proposal.show');
        Route::get('/validasi-usulan/{pkm}', [Dospem::class, 'validasiUsulanDisetujui'])->name('validasi-usulan');
        Route::post('/validate', [Dospem::class, 'validate'])->name('validate');
        Route::post('/logout', [AuthDospem::class, 'logout'])->name('logout');
    });
});

// Route untuk Pimpinan
Route::prefix('perguruan-tinggi')->name('perguruan-tinggi.')->group(function () {

    Route::middleware('guest:pimpinan')->group(function () {
        Route::get('/login', [AuthPimpinan::class, 'create'])->name('login');
        Route::post('/login', [AuthPimpinan::class, 'login']);
    });

    Route::middleware(['auth:pimpinan', 'session.timeout'])->group(function () {
        Route::get('/dashboard', [Pimpinan::class, 'index'])->name('dashboard');
        Route::get('/validasi', [Pimpinan::class, 'showData'])->name('validasi');
        Route::post('/validasi', [Pimpinan::class, 'validasi']);
        Route::post('/validasi-pimpinan-all', [Pimpinan::class, 'validasiAll'])->name('validasi-pimpinan-all');
        Route::post('/validasi-pimpinan-reset', [Pimpinan::class, 'resetValidasi'])->name('validasi-pimpinan-reset');
        Route::post('/logout', [AuthPimpinan::class, 'logout'])->name('logout');
    });
});
