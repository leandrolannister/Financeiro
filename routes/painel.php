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
});
