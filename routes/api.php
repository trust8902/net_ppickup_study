<?php

use App\Http\Controllers\Apps\BoardItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Apps\BoardController;
use App\Http\Controllers\Apps\BoardCommentController;
use App\Http\Controllers\UserController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () {
    Route::prefix('/setting/board')->group(function () {
        Route::get('/', [BoardController::class, 'lists']);
        Route::get('/{id}', [BoardController::class, 'view']);
        Route::post('/', [BoardController::class, 'store']);
        Route::delete('/{id}', [BoardController::class, 'destroy']);
        Route::patch('/{id}', [BoardController::class, 'update']);
    });

    Route::prefix('/board/{alias}')->group(function () {
        Route::get('/', [BoardItemController::class, 'lists']);
        Route::get('/{id}', [BoardItemController::class, 'view']);
        Route::post('/', [BoardItemController::class, 'store']);
        Route::delete('/{id}', [BoardItemController::class, 'destroy']);
        Route::patch('/{id}', [BoardItemController::class, 'update']);

        Route::get('/{id}/comments', [BoardCommentController::class, 'lists']);
        Route::post('/{id}/comments', [BoardCommentController::class, 'store']);
        Route::delete('/{id}/comments/{commentId}', [BoardCommentController::class, 'destroy']);
    });

    Route::get('/user', [UserController::class, 'lists']);
});
