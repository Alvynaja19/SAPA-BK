<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

/*
|--------------------------------------------------------------------------
| API Routes Internal — /api/*
| Semua route ini memerlukan auth session (bukan token Sanctum)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Buat sesi percakapan baru
    Route::post('/chat/session', [ChatController::class, 'newSession'])
        ->name('api.chat.session');

    // Kirim pesan ke chatbot, dapatkan respons
    Route::post('/chat', [ChatController::class, 'send'])
        ->name('api.chat.send');

    // Ambil riwayat sesi tertentu
    Route::get('/chat/history/{id}', [ChatController::class, 'history'])
        ->name('api.chat.history');
});
