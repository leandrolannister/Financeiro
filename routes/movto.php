<?php 

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::group(['middleware' => 'auth'], function(){
  Route::get('/conta', 'MovtosController@contas')
  ->name('movto.conta');

  Route::match(['get', 'post'], '/conta/search', 
  'MovtosController@search')->name('movto.search');

  Route::post('/conta/deposito', 'MovtosController@deposito')
  ->name('movto.deposito');     

  Route::any('/conta/searchFor/lancamento', 
  'MovtosController@searchForLancamento')
  ->name('movto.searchForLancamento');

  Route::post('conta/destroy/','MovtosController@destroy')
  ->name('movto.destroy');
});