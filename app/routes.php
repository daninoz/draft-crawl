<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
    return $_SERVER['DB_HOST'];
});

Route::get('/draft/create', 'DraftController@create');

Route::get('/per/create', 'PerController@create');

Route::get('/per/reorder', 'PerController@reorder');

