<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CounselorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatController;

/*
|--------------------------------------------------------------------------
| HALAMAN PUBLIK (tanpa login)
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/tentang', [PublicController::class, 'tentang'])->name('tentang');
Route::get('/ebook', [PublicController::class, 'ebook'])->name('ebook.public');
Route::get('/artikel', [PublicController::class, 'artikel'])->name('artikel.list');
Route::get('/artikel/{slug}', [PublicController::class, 'artikelDetail'])->name('artikel.detail');
Route::get('/faq', [PublicController::class, 'faq'])->name('faq');

/*
|--------------------------------------------------------------------------
| AUTENTIKASI
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    // Lupa Password
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| HALAMAN SISWA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/chat', [ChatController::class, 'index'])->name('student.chat');
    Route::get('/chat/{session_id}', [ChatController::class, 'show'])->name('student.chat.session');
    Route::get('/riwayat', [StudentController::class, 'riwayat'])->name('student.riwayat');
    Route::get('/ebook/akses', [StudentController::class, 'ebook'])->name('student.ebook');
    Route::get('/tes', [StudentController::class, 'tes'])->name('student.tes');
    Route::get('/tes/{id}', [StudentController::class, 'tesDetail'])->name('student.tes.detail');
    Route::get('/tes/{id}/hasil', [StudentController::class, 'tesHasil'])->name('student.tes.hasil');
    Route::get('/profil', [StudentController::class, 'profil'])->name('student.profil');
    Route::put('/profil', [StudentController::class, 'updateProfil'])->name('student.profil.update');
});

/*
|--------------------------------------------------------------------------
| HALAMAN GURU BK (Juga dapat diakses Admin per SRS F-56)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:guru_bk,admin'])->prefix('bk')->name('counselor.')->group(function () {
    Route::get('/dashboard', [CounselorController::class, 'dashboard'])->name('dashboard');
    Route::get('/siswa', [CounselorController::class, 'siswa'])->name('siswa');
    Route::get('/percakapan', [CounselorController::class, 'percakapan'])->name('percakapan');
    Route::get('/percakapan/{id}', [CounselorController::class, 'percakapanDetail'])->name('percakapan.detail');

    // E-book
    Route::get('/ebook', [CounselorController::class, 'ebook'])->name('ebook');
    Route::post('/ebook', [CounselorController::class, 'ebookStore'])->name('ebook.store');
    Route::delete('/ebook/{id}', [CounselorController::class, 'ebookDestroy'])->name('ebook.destroy');

    // Artikel
    Route::get('/artikel', [CounselorController::class, 'artikel'])->name('artikel');
    Route::post('/artikel', [CounselorController::class, 'artikelStore'])->name('artikel.store');
    Route::post('/artikel/import', [CounselorController::class, 'artikelImport'])->name('artikel.import');
    Route::delete('/artikel/{id}', [CounselorController::class, 'artikelDestroy'])->name('artikel.destroy');

    // Knowledge Base
    Route::get('/knowledge-base', [CounselorController::class, 'knowledgeBase'])->name('knowledge-base');
    Route::post('/knowledge-base', [CounselorController::class, 'knowledgeBaseStore'])->name('knowledge-base.store');
    Route::delete('/knowledge-base/{id}', [CounselorController::class, 'knowledgeBaseDestroy'])->name('knowledge-base.destroy');

    // Tes
    Route::get('/tes', [CounselorController::class, 'tes'])->name('tes');
    Route::get('/tes/{id}/hasil', [CounselorController::class, 'tesHasil'])->name('tes.hasil');

    // Evaluasi chatbot
    Route::get('/evaluasi', [CounselorController::class, 'evaluasi'])->name('evaluasi');
    Route::post('/evaluasi', [CounselorController::class, 'evaluasiStore'])->name('evaluasi.store');

    // FAQ
    Route::get('/faq', [CounselorController::class, 'faq'])->name('faq');
    Route::post('/faq', [CounselorController::class, 'faqStore'])->name('faq.store');
    Route::delete('/faq/{id}', [CounselorController::class, 'faqDestroy'])->name('faq.destroy');
});

/*
|--------------------------------------------------------------------------
| HALAMAN ADMINISTRATOR
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Manajemen user
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users', [AdminController::class, 'userStore'])->name('users.store');
    Route::get('/users/{id}', [AdminController::class, 'userDetail'])->name('users.detail');
    Route::put('/users/{id}', [AdminController::class, 'userUpdate'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'userDestroy'])->name('users.destroy');

    // Konfigurasi & log
    Route::get('/konfigurasi', [AdminController::class, 'konfigurasi'])->name('konfigurasi');
    Route::post('/konfigurasi', [AdminController::class, 'konfigurasiUpdate'])->name('konfigurasi.update');
    Route::get('/log', [AdminController::class, 'log'])->name('log');
    Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan');
});
