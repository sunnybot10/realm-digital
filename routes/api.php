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

Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {
    Route::post('login', 'AuthController@login')->name('api.authenticate');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('register', 'AuthController@register')->name('api.register');
});

Route::group(['middleware' => ['api'],'prefix' => 'contact'], function ($router){
    Route::post('create','ContactController@create')->name('contact.create');
    Route::get('all','ContactController@all')->name('contact.all');
    Route::put('update/{contact}','ContactController@update')->name('contact.update');
    Route::get('show/{contact}','ContactController@show')->name('contact.show');
    Route::post('delete/{contact}','ContactController@delete')->name('contact.delete');
});
