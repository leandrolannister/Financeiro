<?php 

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::group(['middleware' => 'auth'], function(){     

    Route::get('/show', 'PaineisController@show')
    ->name('painel.show');

    Route::get('/meta', 'PaineisController@meta')
    ->name('painel.meta');

    Route::get('/ranking', 'PaineisController@ranking')
    ->name('painel.ranking');

    Route::any('/ranking/search', 'PaineisController@search')
    ->name('painel.ranking');

    Route::get('/grafico', 'PaineisController@grafico')
    ->name('painel.grafico');

    Route::post('/grafico', 'PaineisController@graficoPeriodo')
    ->name('painel.graficoPeriodo');
});
