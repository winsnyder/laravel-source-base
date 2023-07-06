<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(PostController::class)->prefix('posts')->group(function () {
    Route::get('/', 'index')->middleware('jwt.verify');
    Route::get('/{id}','show');
    Route::post('/create', 'store')->middleware('transaction');
    Route::post('/update/{id}', 'update')->middleware('transaction');
    Route::delete('/{id}', 'destroy');
});

//Auth
Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register')->middleware('transaction');
});