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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/produk/json', 'ProductController@index')->name('json');
Route::get('id_user','ProductController@id_user');
Route::get('hitung','HitungController@stok');
Route::get('/{any}','HomeController@index')->where(' any', '.*');