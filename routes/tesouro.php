<?php 

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::group(['middleware' => 'auth'], function(){
  Route::get('/tesouro', 'TesourosController@index')
  ->name('tesouro.index');  

  Route::get('/tesouro/create', 'TesourosController@create')
  ->name('tesouro.create');

  Route::post('/tesouro/store/', 'TesourosController@store')
  ->name('tesouro.store');

  Route::post('/tesouro/upgrade', 'TesourosController@upgrade')
  ->name('tesouro.upgrade');

  Route::post('/tesouro/update', 'TesourosController@update')
  ->name('tesouro.update');

  Route::post('/tesouro/destroy', 'TesourosController@destroy')
  ->name('tesouro.destroy');

});