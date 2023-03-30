<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::post('login', 'App\Http\Controllers\AuthController@login');
// // Route::get('users', 'App\Http\Controllers\UserController@index');
// Route::get('users/{id}', 'App\Http\Controllers\UserController@show');
// Route::post('users/', 'App\Http\Controllers\UserController@create');
// Route::put('users/{id}', 'App\Http\Controllers\UserController@update');
// Route::delete('users/{id}', 'App\Http\Controllers\UserController@destroy');

// Route::middleware('auth:api')->get('users', 'App\Http\Controllers\UserController@index');
Route::group(['prefix' => 'v1'], function () {
    Route::post('login', 'App\Http\Controllers\AuthController@login');

    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('logout', 'App\Http\Controllers\AuthController@logout');
        Route::get('users', 'App\Http\Controllers\UserController@index');
        Route::get('users/{id}', 'App\Http\Controllers\UserController@show');
        Route::post('users/', 'App\Http\Controllers\UserController@create');
        Route::put('users/{id}', 'App\Http\Controllers\UserController@update')->middleware('isAdminOrSelf');
        Route::delete('users/{id}', 'App\Http\Controllers\UserController@destroy')->middleware('isAdminOrSelf');
    });
});
