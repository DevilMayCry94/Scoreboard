<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\GamesController::class, 'index'])->name('home');
Route::get('/games', [\App\Http\Controllers\GamesController::class, 'stats'])->name('game.stat');
Route::post('/game', [\App\Http\Controllers\GamesController::class, 'store'])->name('game.store');
Route::put('/game/{uuid}/start', [\App\Http\Controllers\GamesController::class, 'start'])->name('game.start');
Route::put('/game/{uuid}/finish', [\App\Http\Controllers\GamesController::class, 'finish'])->name('game.finish');
Route::put('/game/{uuid}', [\App\Http\Controllers\GamesController::class, 'update'])->name('game.update');
