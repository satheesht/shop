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
    return redirect("login");
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard/{category}/{attribute}/{search}', 'HomeController@dashboard')->name('dashboard');
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

Route::get('/products/image/{filename}', function ($filename)
{
    $path = storage_path() ."/app/". $filename;

    if(!File::exists($path)) abort(404);

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
});

Route::get('logout', 'Auth\LoginController@logout')->name('logout');
