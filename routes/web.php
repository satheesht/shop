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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
Route::get('/categories', 'HomeController@categories')->name('categories');
Route::get('/attributes', 'HomeController@attributes')->name('attributes');
Route::get('/products', 'HomeController@products')->name('products');

Route::post('/categories/newChild', 'HomeController@newCategoryChild');
Route::delete('/categories/removeChild', 'HomeController@removeChild');
Route::post('/attributes/add', 'HomeController@addNewAttribute');
Route::delete('/attributes/remove', 'HomeController@removeAttribute');
Route::post('/products/addNew', 'HomeController@addNew');
Route::delete('/products/remove', 'HomeController@remove');
Route::get('/ajax/get/categories', 'AdminController@getCategories')->name("getCategories");
