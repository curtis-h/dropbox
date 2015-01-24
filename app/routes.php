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

Route::get('/', 'HomeController@index');
Route::get('/login', 'HomeController@login');
Route::get('/data', 'HomeController@data');
Route::any('/find', 'HomeController@find');
Route::any('/auth', 'HomeController@auth');
Route::get('/create', 'HomeController@create');
Route::post('/save', 'HomeController@saveFile');

Route::post('/upload', 'HomeController@upload');

/* 
Route::any('/create', function() {
    $fd = fopen("./frog.jpeg", "rb");
    $md1 = $client->uploadFile("/Photos/Frog.jpeg",
            dbx\WriteMode::add(), $fd);
    fclose($fd);
    
    return '123';
}); 
*/