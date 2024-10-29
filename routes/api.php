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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->group(function () {
    Route::get('/movies', 'MoviesController@index')->name('api.movies.index');
    Route::get('/movies/{id}', 'MoviesController@show')->name('api.movies.show');

    Route::get('/tv', 'TvController@index')->name('api.tv.index');
    Route::get('/tv/{id}', 'TvController@show')->name('api.tv.show');

    Route::get('/actors', 'ActorsController@index')->name('api.actors.index');
    Route::get('/actors/page/{page?}', 'ActorsController@index')->name('api.actors.page');
    Route::get('/actors/{id}', 'ActorsController@show')->name('api.actors.show');
});
