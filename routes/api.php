<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\EntertainmentsController;
use App\Http\Controllers\EntertainmentsPostController;
use App\Http\Controllers\KeyController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\SendingKeyController;
use App\Http\Controllers\UsersController;
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

Route::prefix('entertainments')->group(function () {
    Route::post('/create', [EntertainmentsController::class, 'store'])->middleware('auth:sanctum');
    Route::get('/get', [EntertainmentsController::class, 'index'])->middleware('auth:sanctum');
    Route::get('/get/{id}', [EntertainmentsController::class, 'show'])->middleware('auth:sanctum');
    Route::post('/update/{id}', [EntertainmentsController::class, 'update'])->middleware('auth:sanctum');
    Route::delete('/delete/{id}', [EntertainmentsController::class, 'destroy'])->middleware('auth:sanctum');
    Route::get('/get-image/{filename}', [EntertainmentsController::class, 'getImage'])->middleware('auth:sanctum');
});

Route::prefix('blog')->group(function () {
    Route::post('/create', [BlogController::class, 'store'])->middleware('auth:sanctum');
    Route::get('/get', [BlogController::class, 'index'])->middleware('auth:sanctum');
    Route::get('/get/{id}', [BlogController::class, 'show'])->middleware('auth:sanctum');
    Route::post('/update/{id}', [BlogController::class, 'update'])->middleware('auth:sanctum');
    Route::delete('/delete/{id}', [BlogController::class, 'destroy'])->middleware('auth:sanctum');
    Route::get('/get-image/{filename}', [EntertainmentsController::class, 'getImage'])->middleware('auth:sanctum');
});

Route::prefix('entertainmentsPost')->group(function () {
    Route::post('/create', [EntertainmentsPostController::class, 'store'])->middleware('auth:sanctum');
    // Route::get('/get', [BlogController::class, 'index'])->middleware('auth:sanctum');
    // Route::get('/get/{id}', [BlogController::class, 'show'])->middleware('auth:sanctum');
    // Route::post('/update/{id}', [BlogController::class, 'update'])->middleware('auth:sanctum');
    // Route::delete('/delete/{id}', [BlogController::class, 'destroy'])->middleware('auth:sanctum');
    // Route::get('/get-image/{filename}',[EntertainmentsController::class, 'getImage'])->middleware('auth:sanctum');
});

Route::post('/sending-key', [SendingKeyController::class, 'sendingKey'])->middleware(['auth:sanctum', 'ability:Admin']);
Route::post('/permission-create', [PermissionController::class, 'permissionCreate'])->middleware(['auth:sanctum', 'ability:Admin']);
Route::get('/permission-list', [PermissionController::class, 'listPermission'])->middleware(['auth:sanctum', 'ability:Admin']);
Route::get('/permission/{id}', [PermissionController::class, 'getPermission'])->middleware(['auth:sanctum', 'ability:Admin']);
Route::put('/permission-update/{id}', [PermissionController::class, 'updatePermission'])->middleware(['auth:sanctum', 'ability:Admin']);
Route::delete('/permission-delete/{id}', [PermissionController::class, 'deletePermission'])->middleware(['auth:sanctum', 'ability:Admin']);

Route::post('/key-create', [KeyController::class, 'keyCreate'])->middleware(['auth:sanctum', 'ability:Admin']);
Route::get('/key-list', [KeyController::class, 'listKey'])->middleware(['auth:sanctum', 'ability:Admin']);
Route::get('/key/{id}', [KeyController::class, 'getKey'])->middleware(['auth:sanctum', 'ability:Admin']);
Route::delete('/key-delete/{id}', [KeyController::class, 'deleteKey'])->middleware(['auth:sanctum', 'ability:Admin']);
Route::get('/key-permission-list', [KeyController::class, 'permissionKeyList'])->middleware(['auth:sanctum', 'ability:Admin']);

Route::get('/users', [UsersController::class, 'getAllUsers'])->middleware(['auth:sanctum', 'ability:Admin']);
Route::get('/user/{id}', [UsersController::class, 'getSingleUser'])->middleware(['auth:sanctum', 'ability:Admin']);
