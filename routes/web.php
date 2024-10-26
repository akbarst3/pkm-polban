<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Operator\UsulanController;
use App\Http\Controllers\Operator\DashboardController;
use App\Http\Controllers\Operator\UreviewerController;
use App\Http\Controllers\Operator\UsulanBaruController;
use App\Http\Controllers\Pengusul\DashboardPengusulController;
<<<<<<< HEAD
use App\Http\Controllers\Pengusul\IdentitasUsulanController;
use App\Http\Controllers\Pengusul\PengesahanController;
use App\Http\Controllers\Pengusul\ProposalController;
=======
use App\Http\Controllers\Pengusul\AuthController as pengusul;
>>>>>>> e728d73 (add: login handling pengusul)

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:operator', 'session.timeout'])->group(function () {
    Route::get('/operator/dashboard', [DashboardController::class, 'index'])->name('operator.dashboard');
    Route::post('/operator/dashboard', [DashboardController::class, 'storeFile'])->name('operator.file');

    Route::middleware(['cek.surat'])->group(function () {
        Route::get('/operator/usulan-baru', [UsulanController::class, 'index'])->name('operator.usulan.baru');
        Route::get('/operator/usulan-baru/{nim}', [UsulanController::class, 'viewData'])->name('operator.usulan.baru.nim');
        Route::delete('/operator/usulan-baru/{id}', [UsulanController::class, 'deleteData'])->name('delete.pengusul');
        Route::get('/operator/identitas-usulan', [UsulanBaruController::class, 'index'])->name('operator.identitas.usulan');
        Route::post('/operator/identitas-usulan/store', [UsulanBaruController::class, 'storeData'])->name('operator.usulan.baru.store');
        Route::post('/operator/identitas-usulan/find', [UsulanBaruController::class, 'findDosen'])->name('operator.identitas.usulan.find');
        Route::view('/operator/usulan-didanai', 'operator.usulan-didanai')->name('operator.usulan-didanai');
        Route::view('/operator/usulan-reviewer', 'operator.usulanReviewer');
        Route::get('/operator/identitas-reviewer', [UreviewerController::class, 'index']);
    });
});



Route::get('/pengusul/dashboard', [DashboardPengusulController::class,'index'])->name('pengusul.dashboard');
Route::get('pengusul/identitas-usulan', [IdentitasUsulanController::class, 'showIdentitasUsulan'])->name('pengusul.identitas.usulan');
Route::post('pengusul/identitas-usulan', [IdentitasUsulanController::class, 'submitIdentitasUsulan'])->name('pengusul.identitas.submit');

Route::post('/pengusul/pengesahan/post', [PengesahanController::class, 'store'])->name('pengusul.pengesahan.store');
Route::get('/pengusul/pengesahan', [PengesahanController::class, 'index'])->name('pengusul.pengesahan');
Route::get('/pengusul/proposal', [ProposalController::class, 'upload'])->name("pengusul.proposal");
Route::post('/pengusul/proposal', [ProposalController::class, "uploadPost"])->name("pengusul.proposal.post");

// Route::get('/pengusul/proposal', [ProposalController::class, 'upload'])->name("pengusul.proposal.upload");
// Route::post('/pengusul/proposal', [ProposalController::class, "uploadPost"])->name("pengusul.proposal.post");
// Route::get('/proposal/view/{id}', [ProposalController::class, 'viewFile'])->name('proposal.view');

require __DIR__.'/auth.php';


Route::prefix('pengusul')->name('pengusul.')->group(function () {
    // Route untuk guest pengusul
    Route::middleware('guest:pengusul')->group(function () {
        Route::get('/login', [pengusul::class, 'create'])->name('login');
        Route::post('/login', [pengusul::class, 'login']);
    });

    // Route untuk authenticated pengusul
    Route::middleware(['auth:pengusul', 'session.timeout'])->group(function () {
        Route::post('/logout', [pengusul::class, 'logout'])->name('logout');
        Route::get('/dashboard', [DashboardPengusulController::class, 'index'])->name('dashboard');
        // Route lain untuk pengusul yang sudah login
    });
});

require __DIR__ . '/auth.php';
