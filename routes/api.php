<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\SendingKeyController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthenticationController::class, 'createAccount']);
    Route::post('/login', [AuthenticationController::class, 'signin']);
    Route::get('/logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset']);
    Route::post('/forgot-password', [ResetPasswordController::class, 'forgot']);
});

Route::post('/sending-key',[SendingKeyController::class, 'sendingKey']);//->middleware(['auth:sanctum', 'ability:Admin']);
