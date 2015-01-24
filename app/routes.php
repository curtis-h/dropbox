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
Route::get('/data', 'HomeController@data');
Route::any('/find', 'HomeController@find');
Route::any('/test', function() {
    dd('hello');
});

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