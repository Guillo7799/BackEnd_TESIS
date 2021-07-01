<?php

use App\Models\Publication;
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

//Rutas para Publication

Route::get('publications', 'App\Http\Controllers\PublicationController@index');
Route::get('publications/{publication}', 'App\Http\Controllers\PublicationController@show');
Route::post('publications', 'App\Http\Controllers\PublicationController@store');
Route::put('publications/{publication}', 'App\Http\Controllers\PublicationController@update');
Route::delete('publications/{publication}', 'App\Http\Controllers\PublicationController@delete');
