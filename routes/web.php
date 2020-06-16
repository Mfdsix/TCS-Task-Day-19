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

Route::redirect('/home', '/')->name('home');
Route::get('/', function () {
	return view('welcome');
});


Auth::routes();


Route::group(['middleware' => 'auth'], function(){
	# are you admin ?
	Route::group(['middleware' => 'is.role:admin'], function(){
		# read user own blogs
		Route::get('/admin', 'AdminController@index');
		# create blog
		Route::get('/admin/create', 'AdminController@create');
		Route::post('/admin/create', 'AdminController@store');
		# edit blog
		Route::get('/admin/edit/{id}', 'AdminController@edit');
		Route::put('/admin/edit/{id}', 'AdminController@update');
		# delete blog
		Route::delete('/admin/delete/{id}', 'AdminController@delete');
		# export blogs
		Route::get('/admin/export', 'AdminController@export');
	});
});

# show blogs
Route::get('blog', 'BlogController@index');
Route::get('blog/{id}', 'BlogController@show');
#show blogs by author
Route::get('blog/author/{id}', 'BlogController@author');
