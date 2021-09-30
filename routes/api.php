<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\FileTypeController;
use App\Http\Controllers\Api\UserFilesController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\FileTypeFilesController;

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

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource('file-types', FileTypeController::class);

        // FileType Files
        Route::get('/file-types/{fileType}/files', [
            FileTypeFilesController::class,
            'index',
        ])->name('file-types.files.index');
        Route::post('/file-types/{fileType}/files', [
            FileTypeFilesController::class,
            'store',
        ])->name('file-types.files.store');

        Route::apiResource('users', UserController::class);

        // User Files
        Route::get('/users/{user}/files', [
            UserFilesController::class,
            'index',
        ])->name('users.files.index');
        Route::post('/users/{user}/files', [
            UserFilesController::class,
            'store',
        ])->name('users.files.store');

        Route::apiResource('files', FileController::class);
    });
