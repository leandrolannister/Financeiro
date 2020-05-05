<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::group(['middleware' => 'auth'], function(){
  
  Route::get('/conta/settings', 'ContasController@index')
  ->name('conta.index');

  Route::post('/conta/store', 'ContasController@store')
  ->name('conta.store'); 

  Route::get('/conta/show', 'ContasController@show')
  ->name('conta.show'); 

  Route::any('/conta/search', 'ContasController@search')
  ->name('conta.search');

  Route::post('/conta/upgrade/', 
  'ContasController@upgrade')->name('conta.upgrade');

  Route::post('/conta/update', 'ContasController@update')
  ->name('conta.update');

  Route::post('/conta/turn/', 'ContasController@turn')
  ->name('conta.turn');

  Route::post('/conta/destroy/', 'ContasController@destroy')
  ->name('conta.destroy');

  Route::get('/conta/saldo', 'ContasController@saldo')
  ->name('conta.saldo');

  Route::post('/conta/saldo/search', 
  'ContasController@saldosearch')->name('contaSaldo.search');

  Route::get('/conta/obrigatorias/show',
  'ContasController@contasObrigatorias')
  ->name('contas.obrigatorias');
});