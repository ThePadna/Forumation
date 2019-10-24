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
    return view('home');
});
Route::post('/postthread', 'ForumController@postThread');
Route::post('/postcategory', 'ForumController@postCategory');
Route::post('/categoryswitchid', 'ForumController@categorySwitchId');
Route::post('/delcategory', 'ForumController@delCategory');
Route::post('/editcategory', 'ForumController@editCategory');
Route::get('/forum/category/{category}/thread/{thread}', 'ForumController@showThread');
Route::get('/forum/category/{category}/post', 'ForumController@showThreadPostForm');
Route::get('/forum/category/{category}/{page}', 'ForumController@showCategory');
Route::get('/forum', 'ForumController@showCategories');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
