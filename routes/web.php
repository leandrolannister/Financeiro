<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');

/*Admin->Usuário
Route::group(['prefix' => 'admin', 'namespace' => 'Usuario',
	          'middleware' => 'auth'],
  function(){
    Route::get('/usuario/settings', 'UsuariosController@index')
    ->name('usuario.index');

    Route::post('/usuario/update', 'UsuariosController@update')
    ->name('usuario.update');
});*/

/*Admin->Grupo de Contas
Route::group(['prefix' => 'admin', 'namespace' => 'GrupoContas',
              'middleware' => 'auth'],
   function(){
     
     Route::get('/grupocontas/settings', 
     'GrupoContasController@index')->name('grupocontas.index');

     Route::post('/grupocontas/store', 
     'GrupoContasController@store')->name('grupocontas.store');

     Route::get('/grupocontas/show', 'GrupoContasController@show')
     ->name('grupocontas.show'); 

     Route::match(['get', 'post'],'/grupocontas/search', 
     'GrupoContasController@search')->name('grupocontas.search');

     Route::post('/grupocontas/upgrade/',
     'GrupoContasController@upgrade')->name('grupocontas.upgrade');

     Route::post('/grupocontas/update',
     'GrupoContasController@update')->name('grupocontas.update');

     Route::post('/grupocontas/turn/',
     'GrupoContasController@turn')->name('grupocontas.turn');

     Route::post('/grupocontas/destroy',
     'GrupoContasController@destroy')
     ->name('grupocontas.destroy');
});
*/

/*Admin->Conta
Route::group(['prefix' => 'admin', 'namespace' => 'Conta',
              'middleware' => 'auth'],
   function(){
     
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

   });*/

/*Movto->Grupo de Contas
Route::group(['prefix' => 'movto', 'namespace' => 'Movto',
              'middleware' => 'auth'],
   function(){
     
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
});*/

//Painel
/*Route::group(['prefix' => 'painel', 'namespace' => 'Painel',
             'middleware' => 'auth'], 
  function(){     

     Route::get('/show', 'PaineisController@show')
     ->name('painel.show');

     Route::get('/meta', 'PaineisController@meta')
     ->name('painel.meta');
});*/

/*Ações
Route::group(['prefix' => 'admin', 'namespace' => 'Acoes',
              'middleware' => 'auth'], 
  function(){

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
});*/

/*Tesouro
Route::group(['prefix' => 'admin', 'namespace' => 'Tesouro',
              'middleware' => 'auth'],
  function(){

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

});*/



