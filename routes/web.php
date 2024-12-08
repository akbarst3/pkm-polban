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

Route::get('/', function () {
    return view('home');
});
Route::get('/login', function () {
    return view('login');
});


// Route untuk Operator
Route::prefix('operator')->name('operator.')->group(function () {

    Route::middleware(['auth:operator', 'session.timeout'])->group(function () {
        Route::get('/dashboard', [Operator::class, 'index'])->name('dashboard');
        Route::post('/dashboard', [Operator::class, 'storeFile'])->name('file');

        Route::middleware(['cek.surat'])->group(function () {
            
            Route::prefix('daftar-usulan')->name('daftar-usulan.')->group(function () {
                Route::get('/', [Operator::class, 'index2']);
                Route::get('/usulan-baru', [Operator::class, 'index1'])->name('usulan-baru');
                Route::get('/{nim}', [Operator::class, 'viewData'])->name('nim');
                Route::delete('/{nim}', [Operator::class, 'deleteData'])->name('delete');
                Route::post('/usulan-baru/store', [Operator::class, 'storeData'])->name('usulan-baru.store');
                Route::post('/usulan-baru/find', [Operator::class, 'findDosen'])->name('usulan-baru.find');
            });        
            Route::get('/usulan-didanai', [Operator::class, 'createDidanai'])->name('usulan-didanai');
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
        Route::prefix('identitas-usulan')->name('identitas-usulan.')->group(function () {
            Route::get('/', [Pengusul::class, 'showData'])->name('index');
            Route::get('/edit-usulan', [Pengusul::class, 'showDetail'])->name('edit-usulan');
            Route::patch('/edit-usulan/edit-mhs/{id}', [Pengusul::class, 'editMhs'])->name('edit-usulan.edit-mhs');
            Route::get('/pengesahan', [Pengusul::class, 'createPengesahan'])->name('pengesahan');
            Route::post('/pengesahan', [Pengusul::class, 'storePengesahan']);
            Route::patch('/edit-usulan/edit-pkm/{id}', [Pengusul::class, 'editPkm'])->name('edit-usulan.edit-pkm');
            Route::get('/edit-usulan/tambah-anggota', [Pengusul::class, 'tambahAnggota'])->name('edit-usulan.tambah-anggota');
            Route::post('/edit-usulan/tambah-anggota', [Pengusul::class, 'storeAnggota']);
            Route::get('/edit-usulan/edit-anggota/{id}', [Pengusul::class, 'createEditAnggota'])->name('edit-usulan.edit-anggota');
            Route::put('/edit-usulan/edit-anggota/{id}', [Pengusul::class, 'editAnggota']);
            Route::delete('/edit-usulan/hapus-anggota/{id}', [Pengusul::class, 'destroyAnggota'])->name('edit-usulan.hapus-anggota');
            Route::get('/proposal', [Pengusul::class, 'createProposal'])->name("proposal");
            Route::patch('/proposal', [Pengusul::class, "storeProposal"]);
            Route::get('/download-proposal', [Pengusul::class, 'downloadProposal'])->name('download-proposal');
        });
        
        Route::prefix('pelaksanaan')->name('pelaksanaan.')->group(function () {
            Route::middleware(['pelaksanaan'])->group(function () {
                Route::get('/dashboard-pelaksanaan', [Pelaksanaan::class, 'createDashboard'])->name('dashboard-pelaksanaan');
                Route::prefix('logbook-kegiatan')->name('logbook-kegiatan.')->group(function () {
                    Route::get('/', [Pelaksanaan::class, 'createLbkeg'])->name('index');
                    Route::get('/tambah-logbook', [Pelaksanaan::class, 'formLbKeg'])->name('tambah-logbook');
                    Route::post('/create', [Pelaksanaan::class, 'storeLbKeg'])->name('create');
                    Route::get('/edit-logbook/{id}', [Pelaksanaan::class, 'editLbKeg'])->name('edit-logbook');
                    Route::get('/private-files/{path}', [Pelaksanaan::class, 'showFile'])->where('path', '.*')->name('private-files');
                    Route::patch('/update/{id}', [Pelaksanaan::class, 'updateLbKeg'])->name('update');
                    Route::get('/download/{id}', [Pelaksanaan::class, 'downloadLbKeg'])->name('download');
                    Route::delete('/delete/{id}', [Pelaksanaan::class, 'deleteLbKeg'])->name('delete');
                });
                
                Route::get('/logbook-keuangan', [Pelaksanaan::class, 'dashboardLogbookKeuangan'])->name('logbook-keuangan');
                Route::get('/form-tambah-logbook-keuangan', [Pelaksanaan::class, 'formTambahLogbookKeuangan'])->name('form-tambah-logbook-keuangan');
                Route::post('/store-logbook-keuangan', [Pelaksanaan::class, 'storeLogbookKeuangan'])->name('store-logbook-keuangan');
                Route::get('/download-bukti/{id}', [Pelaksanaan::class, 'downloadBukti'])->name('download-bukti');
                Route::delete('/hapus-logbook-keuangan/{id}', [Pelaksanaan::class, 'hapusLogbookKeuangan'])->name('hapus-logbook-keuangan');
                Route::get('/edit-logbook-keuangan/{id}', [Pelaksanaan::class, 'editLogbookKeuangan'])->name('edit-logbook-keuangan');
                Route::put('/update-logbook-keuangan/{id}', [Pelaksanaan::class, 'updateLogbookKeuangan'])->name('update-logbook-keuangan');
                Route::get('/lap-kemajuan', [Pelaksanaan::class, 'kemajuan'])->name('lap-kemajuan');
                Route::post('/lap-kemajuan/upload-file', [Pelaksanaan::class, 'uploadFile'])->name('lap-kemajuan.uploadFile');
                Route::get('/lap-kemajuan/download-file/{id}', [Pelaksanaan::class, 'downloadFile'])->name('lap-kemajuan.downloadFile');
                Route::get('/luaran-kemajuan', [Pelaksanaan::class, 'createLuaranKemajuan'])->name('luaran-kemajuan');
                Route::get('/luaran-akhir', [Pelaksanaan::class, 'createLuaranAkhir'])->name('luaran-akhir');
                Route::post('/store-social-media', [Pelaksanaan::class, 'storeSocialMedia'])->name('store-social-media');
                Route::post('/update-social-media', [Pelaksanaan::class, 'updateSocialMedia'])->name('update-social-media');
                Route::get('/laporan-akhir', [Pelaksanaan::class, 'createLaporanAkhir'])->name('laporan-akhir');
                Route::patch('/upload-lapkhir/{id}', [Pelaksanaan::class, 'storeFile'])->name('upload-lapkhir');
                Route::get('/laporan-akhir/download-lapkhir/{id}', [Pelaksanaan::class, 'downloadLapkhir'])->name('laporan-akhir.downloadLapkhir');
                Route::get('/profile', [Pelaksanaan::class, 'createProfile'])->name('profile');
                Route::patch('/profile/update', [Pelaksanaan::class, 'updateProfile'])->name('profile.update');
                Route::get('/profile/open-photo/{path}', [Pelaksanaan::class, 'openPhoto'])->where('path', '.*')->name('profile.open-photo');
            });
        });
        Route::post('/logout', [AuthPengusul::class, 'logout'])->name('logout');
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
        Route::prefix('validasi-logbook')->name('validasi-logbook.')->group(function () {
            Route::get('/', [Dospem::class, 'validasiLogbook'])->name('index');
            Route::get('/logbook-kegiatan/{pkm}', [Dospem::class, 'validasiLogbookKegiatan'])->name('logbook-kegiatan');
            Route::get('/logbook-keuangan/{pkm}', [Dospem::class, 'validasiLogbookKeuangan'])->name('logbook-keuangan');
            Route::patch('/logbook-kegiatan/approve/{logbook}', [Dospem::class, 'approveLogbookKegiatan'])->name('logbook-kegiatan.approve');
            Route::patch('/logbook-kegiatan/reject/{logbook}', [Dospem::class, 'rejectLogbookKegiatan'])->name('logbook-kegiatan.reject');
            Route::patch('/logbook-keuangan/approve/{logbook}', [Dospem::class, 'approveLogbookKeuangan'])->name('logbook-keuangan.approve');
            Route::patch('/logbook-keuangan/reject/{logbook}', [Dospem::class, 'rejectLogbookKeuangan'])->name('logbook-keuangan.reject');
        });
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
