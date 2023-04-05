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
    Route::post('logApi', 'App\Http\Controllers\LogController@logApi');
    Route::post('logWarn', 'App\Http\Controllers\LogController@logWarn');
    Route::post('logError', 'App\Http\Controllers\LogController@logError');



    Route::group(['middleware' => 'auth:api'], function(){
        //Usuarios
        Route::get('logout', 'App\Http\Controllers\AuthController@logout');
        Route::get('users', 'App\Http\Controllers\UserController@index');
        Route::get('users/{id}', 'App\Http\Controllers\UserController@show');
        Route::post('users/', 'App\Http\Controllers\UserController@create');
        Route::put('users/{id}', 'App\Http\Controllers\UserController@update')->middleware('isAdminOrSelf');
        Route::delete('users/{id}', 'App\Http\Controllers\UserController@destroy')->middleware('isAdminOrSelf');
        //Endereços
        Route::get('address', 'App\Http\Controllers\AddressController@getAddresses');
        Route::post('address/', 'App\Http\Controllers\AddressController@createAddress');
    });
});


/*  buscaCep (cep) {
      if (cep.length === 8) {
        const url = 'https://viacep.com.br/ws/' + cep + '/json/'
        try {
          const response = this.$axios.get(`${url}`)
          const retorno = response.data
          if (!retorno.cep) {
            this.mensagemWarning('Erro no cep')
          }
          this.form.rua = retorno.logradouro
          this.form.cidade = retorno.localidade
          this.form.estado = retorno.uf
          this.form.bairro = retorno.bairro
          this.form.cep = cep
        } catch (error) {
          this.mensagemErro('Erro ao buscar endereço', error)
        }
      }*/
