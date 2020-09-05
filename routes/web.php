<?php

use Illuminate\Support\Facades\Route;

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

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
    
});

Route::group([

    'middleware' => 'api'

], function ($router) {

    Route::get('documents', 'DocumentController@index');
    Route::get('documents_dir', 'DocumentController@read');
    Route::get('search_documents', 'DocumentController@search');
    Route::post('document_delete', 'DocumentController@delete');
    
});

Route::post('register', 'AuthController@register');
Route::post('store-file', 'DocumentController@store');

Route::get('/', 'IndexController@index')->name('index');
// Route::get('/blogs', 'BlogController@index')->name('blog');
