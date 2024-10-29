<?php

use App\Http\Controllers\ActorsController;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\TvController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/movies', [MoviesController::class, 'index'])->name('api.movies.index');
Route::get('/movies/{id}', [MoviesController::class, 'show'])->name('api.movies.show');

Route::get('/tv', [TvController::class, 'index'])->name('api.tv.index');
Route::get('/tv/{id}', [TvController::class, 'show'])->name('api.tv.show');

Route::get('/actors', [ActorsController::class, 'index'])->name('api.actors.index');
Route::get('/actors/page/{page?}', [ActorsController::class, 'index'])->name('api.actors.page');
Route::get('/actors/{id}', [ActorsController::class, 'show'])->name('api.actors.show');
