<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', 'App\Http\Controllers\AuthController@login');
Route::get('users', 'App\Http\Controllers\UserController@index');
Route::get('users/{id}', 'App\Http\Controllers\UserController@show');
Route::post('users/', 'App\Http\Controllers\UserController@create');
Route::put('users/{id}', 'App\Http\Controllers\UserController@update');
Route::delete('users/{id}', 'App\Http\Controllers\UserController@destroy');

