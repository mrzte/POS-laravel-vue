<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('kategori','CategoryController');
Route::apiResource('produk','ProductController');
Route::get('kategori2','CategoryController@index2');
Route::get('id_user','ProductController@id_user');
Route::get('hitung','HitungController@index');
Route::get('hitung_stok','HitungController@stok');
Route::apiResource('role','RoleController');
Route::apiResource('users','UserController');