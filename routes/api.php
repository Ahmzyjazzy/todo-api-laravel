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
// Route::middleware(['cors', 'json.response', 'auth:api'])->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['cors', 'json.response']], function () { 
    // public routes with no auth
    Route::post('/register','UserController@register')->name('register.api'); 
    Route::post('/login', 'UserController@login')->name('login.api');  
    Route::get('/unathorised', 'UserController@unAthorised')->name('unathorised'); 
});

Route::group(['middleware' => ['cors', 'json.response', 'auth:api']], function () { 
    // user routes with auth
    Route::post('/logout', 'UserController@logout')->name('logout.api');
    Route::get('/user', 'UserController@getAuthUser')->name('logout.api');

    Route::post('todos', 'TodoController@store');
    Route::put('todos', 'TodoController@update');
    Route::delete('todos/{id}', 'TodoController@destroy');
    Route::get('todos/{id}', 'TodoController@show'); 
    Route::get('todos', 'TodoController@index');
});

Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact olanrewajuahmed095@yahoo.com'], 404);
});