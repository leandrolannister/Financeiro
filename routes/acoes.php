<?php 

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::group(['middleware' => 'auth'], function(){
  Route::get('/acoes', 'AcoesController@index')
  ->name('acoes.index');
    
  Route::get('/acoes/create', 'AcoesController@create')
  ->name('acoes.create');

  Route::post('/acoes/store', 'AcoesController@store')
  ->name('acoes.store');

  Route::post('/acoes/upgrade', 'AcoesController@upgrade')
  ->name('acoes.upgrade');

  Route::post('/acoes/update', 'AcoesController@update')
  ->name('acoes.update');

  Route::post('/acoes/destroy', 'AcoesController@destroy')
  ->name('acoes.destroy');
});