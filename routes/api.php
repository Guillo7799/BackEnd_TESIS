<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

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

// Rutas públicas

Route::post('register', 'App\Http\Controllers\UserController@register');
Route::post('businessregister', 'App\Http\Controllers\UserController@businessregister');
Route::post('login', 'App\Http\Controllers\UserController@authenticate');
Route::get('comments', 'App\Http\Controllers\CommentController@index');
Route::get('comments/{comment}', 'App\Http\Controllers\CommentController@show');
Route::get('categories', 'App\Http\Controllers\CategoryController@index');

// Rutas privadas
Route::group(['middleware' => ['jwt.verify']], function () {

    // Rutas para usuarios
    Route::get('user', 'App\Http\Controllers\UserController@getAuthenticatedUser');
    Route::get('users', 'App\Http\Controllers\UserController@index');
    Route::get('users/{user}', 'App\Http\Controllers\UserController@show');
    Route::put('users/student/{user}', 'App\Http\Controllers\UserController@update');
    Route::put('users/{user}', 'App\Http\Controllers\UserController@updateBusiness');
    Route::delete('users/{user}', 'App\Http\Controllers\UserController@delete');
    Route::post('logout', 'App\Http\Controllers\UserController@logout');

    // Ruta para ver las publicaciones del usuario
    Route::get('/users/publications/{user}','App\Http\Controllers\UserController@showUserPublications');

    // Ruta para ver la solicitud del usuario
    Route::get('users/applications/{user}','App\Http\Controllers\UserController@showUserApplication');

    // Ruta para ver el curriculum del usuario
    Route::get('users/curriculum/{user}','App\Http\Controllers\UserController@showUserCurriculum');
    
    // Ruta para visualizar el detalle de la postulación de una publicación.
    Route::get('users/{user}/publication/application','App\Http\Controllers\UserController@showApplicationPublication');

    // Ruta para actualizar la postulación a una publicación por parte de la empresa
    Route::put('users/{user}/publication/application','App\Http\Controllers\UserController@UpdateShowApplicationPublication');

    // Rutas para Hojas de vida
    Route::get('cvitaes', 'App\Http\Controllers\CVitaeController@index');
    Route::get('cvitaes/{cvitae}', 'App\Http\Controllers\CVitaeController@show');
    Route::post('cvitaes', 'App\Http\Controllers\CVitaeController@store');
    Route::put('users/{user}/cvitae', 'App\Http\Controllers\CVitaeController@update');
    Route::delete('cvitaes/{cvitae}', 'App\Http\Controllers\CVitaeController@delete');

    // Rutas para publicaciones de oferta
    Route::get('publications', 'App\Http\Controllers\PublicationController@index');
    Route::get('publications/{publication}', 'App\Http\Controllers\PublicationController@show');
    Route::post('publications', 'App\Http\Controllers\PublicationController@store');
    Route::put('publications/{publication}', 'App\Http\Controllers\PublicationController@update');
    Route::delete('publications/{publication}', 'App\Http\Controllers\PublicationController@delete');

    //Ruta para filtrado de publicaciones
    Route::get('publications/category/{category}','App\Http\Controllers\PublicationController@publicationFilter');

    //Ruta para visualización de postulaciones por publicación
    Route::get('publications/{publication}/applications','App\Http\Controllers\PublicationController@applicationByPublication');

    // Rutas para comentarios    
    Route::post('comments', 'App\Http\Controllers\CommentController@store');
    Route::delete('comments/{comment}', 'App\Http\Controllers\CommentController@delete');

    // Rutas para las categorías
    Route::get('categories', 'App\Http\Controllers\CategoryController@index');
    Route::get('categories/{category}', 'App\Http\Controllers\CategoryController@show');
    Route::post('categories', 'App\Http\Controllers\CategoryController@store');
    Route::put('categories/{category}', 'App\Http\Controllers\CategoryController@update');
    Route::delete('categories/{category}', 'App\Http\Controllers\CategoryController@delete');

    // Rutas para postulaciones
    Route::get('applications','App\Http\Controllers\ApplicationController@index');
    Route::get('applications/{application}', 'App\Http\Controllers\ApplicationController@show');
    Route::post('applications', 'App\Http\Controllers\ApplicationController@store');
    Route::put('applications/{application}', 'App\Http\Controllers\ApplicationController@update');
    Route::delete('applications/{application}', 'App\Http\Controllers\ApplicationController@delete');
});