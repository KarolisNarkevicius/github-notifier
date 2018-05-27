<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['namespace' => 'Webhooks'], function() {
    Route::get('/notify', 'GitHubController@notify');
    Route::post('/notify', 'GitHubController@notify');
});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
Route::redirect('home', 'repositories');

Route::resource('repositories', 'RepositoriesController');