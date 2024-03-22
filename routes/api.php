<?php

use App\Http\Controllers\AccessController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\UserController;
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

Route::post('/signup', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logout', [UserController::class, 'logout']);
    Route::prefix('files')->group(function () {
        Route::post('/', [FileController::class, 'store']);
        Route::get('/disk', [FileController::class, 'index']);
        Route::get('/shared', [FileController::class, 'shared']);
        Route::get('/{file}', [FileController::class, 'show'])->middleware('can:download,file');
        Route::patch('/{file}', [FileController::class, 'update'])->middleware('can:update,file');
        Route::delete('/{file}', [FileController::class, 'destroy'])->middleware('can:delete,file');

        Route::post('/{file}/accesses', [AccessController::class, 'store'])->middleware('can:accessAdd,file');
        Route::delete('/{file}/accesses', [AccessController::class, 'destroy'])->middleware('can:accessRemove,file');
    });
});
