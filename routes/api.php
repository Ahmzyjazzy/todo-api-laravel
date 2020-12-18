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
Route::middleware(['cors', 'json.response', 'auth:api'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['cors', 'json.response']], function () { 
    // public routes with no auth
    Route::post('/register','UserController@register')->name('register.api'); 
    Route::post('/login', 'UserController@login')->name('login.api');  
    Route::get('/unathorised', 'UserController@unAthorised')->name('unathorised'); 
});

Route::group(['middleware' => ['cors', 'json.response', 'auth:api']], function () { 
    // user routes with auth
    Route::post('/logout', 'UserController@logout')->name('logout.api');
    Route::post('/user', 'UserController@logout')->name('logout.api');

    Route::post('todo', 'TodoController@store');
    Route::put('todo', 'TodoController@store');
    Route::delete('todo/{id}', 'TodoController@destroy');
    Route::get('todo/{id}', 'TodoController@show'); 
    Route::get('todos', 'TodoController@index');
});