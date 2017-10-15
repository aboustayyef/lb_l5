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

Route::get('/', function(){
    return response('This is the home page. You don\'t have to be logged in to see this', 200);
});

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

Route::prefix('api')->middleware('auth')->group(function(){
	Route::get('blog', function(){
		return App\Blog::all();
	});
});

Route::prefix('admin')->middleware('auth')->group(function(){
    Route::resource('blog', 'AdminBlogController')->except('show');
    Route::resource('tag', 'AdminTagController')->except('show');
    Route::get('/', 'AdminController@index');
});
