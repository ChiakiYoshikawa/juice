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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/product','App\Http\Controllers\ProductController@index')->name('product.index');
Route::get('/product/create','App\Http\Controllers\ProductController@create')->name('product.create');
Route::post('/product/store/','App\Http\Controllers\ProductController@store')->name('product.store');
Route::get('/product/show/{product}', 'App\Http\Controllers\ProductController@show')->name('product.show');
Route::delete('/product/{product}','App\Http\Controllers\ProductController@destroy')->name('product.destroy');
Route::get('/product/edit/{product}','App\Http\Controllers\ProductController@edit')->name('product.edit');
Route::put('/product/edit/{product}','App\Http\Controllers\ProductController@update')->name('product.update');
Route::get('/products/search', 'App\Http\Controllers\ProductController@search')->name('product.search');

