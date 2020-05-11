<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::group(['middleware' => 'auth'], function(){
     
     Route::get('/grupocontas/settings', 
     'GrupoContasController@index')
     ->name('grupocontas.index');

     Route::post('/grupocontas/store', 
     'GrupoContasController@store')
     ->name('grupocontas.store');

     Route::get('/grupocontas/show', 'GrupoContasController@show')
     ->name('grupocontas.show'); 

     Route::match(['get', 'post'],'/grupocontas/search', 
     'GrupoContasController@search')->name('grupocontas.search');

     Route::post('/grupocontas/upgrade/',
     'GrupoContasController@upgrade')
     ->name('grupocontas.upgrade');

     Route::post('/grupocontas/update',
     'GrupoContasController@update')->name('grupocontas.update');

     Route::post('/grupocontas/turn/',
     'GrupoContasController@turn')->name('grupocontas.turn');

     Route::post('/grupocontas/destroy',
     'GrupoContasController@destroy')
     ->name('grupocontas.destroy');

});