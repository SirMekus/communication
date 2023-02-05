<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('check-header')->group(function(){
    Route::get('get-me', [App\Api\V1\Controllers\MessageController::class, 'getMe']);

    Route::get('get-update', [App\Api\V1\Controllers\MessageController::class, 'getUpdate']);

    Route::post('invite-to-channel', [App\Api\V1\Controllers\MessageController::class, 'inviteToChannel']);

    Route::post('send-message', [App\Api\V1\Controllers\MessageController::class, 'sendMessage']);
});

Route::post('{token}/webhook', [App\Api\V1\Controllers\MessageController::class, 'getWebhookMessage'])->name('webhook');