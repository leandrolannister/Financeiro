<?php

use Illuminate\Support\Facades\Route;

//Auth::routes();

Route::group(['middleware' => 'auth'], function(){
    
    Route::get('/usuario/settings', 'UsuariosController@index')
    ->name('usuario.index');

    Route::post('/usuario/update', 'UsuariosController@update')
    ->name('usuario.update');
});