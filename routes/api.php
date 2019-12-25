<?php

use Illuminate\Http\Request;

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

Route::get('/vols', 'VolController@index');
Route::get('/vol/{id}', 'VolController@show');
Route::post('/vol', 'VolController@store');
Route::put('/vol', 'VolController@store');
Route::delete('/vol/{id}', 'VolController@destroy');


Route::get('/reservations', 'ReservationController@index');
Route::get('/reservation/{id}', 'ReservationController@show');
Route::post('/reservation', 'ReservationController@store');
Route::put('/reservation', 'ReservationController@store');
Route::delete('/reservation/{id}', 'ReservationController@destroy');