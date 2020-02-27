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
Route::post('/postEditorModeUpdate', 'ForumController@postEditorModeUpdate');
Route::post('/erasepost', 'ForumController@erasePost');
Route::post('/likepost', 'ForumController@likePost');
Route::post('/delthread', 'ForumController@delThread');
Route::post('/postColorUpdate', 'ForumController@postColorUpdate');
Route::post('/postreply', 'ForumController@postReply');
Route::post('/postthread', 'ForumController@postThread');
Route::post('/postcategory', 'ForumController@postCategory');
Route::post('/categoryswitchid', 'ForumController@categorySwitchId');
Route::post('/delcategory', 'ForumController@delCategory');
Route::post('/editcategory', 'ForumController@editCategory');
Route::get('/forum/admin', 'ForumController@showCtrlPanel');
Route::post('/forum/profile/{user}/edit/updateprofile', 'UserController@updateProfile');
Route::get('/forum/profile/{user}', 'ForumController@showUserProfile');
Route::get('/forum/profile/{user}/edit', 'UserController@editProfile');
Route::get('/forum/category/{category}/thread/{thread}/{page}', 'ForumController@showThread');
Route::get('/forum/category/{category}/post', 'ForumController@showThreadPostForm');
Route::get('/forum/category/{category}/{page}', 'ForumController@showCategory');
Route::get('/forum', 'ForumController@showCategories');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
