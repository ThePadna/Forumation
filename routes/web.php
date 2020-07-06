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
Route::post('/postEditorModeUpdate', 'AdminController@postEditorModeUpdate');
Route::post('/updatesettings', 'AdminController@updateSettings');
Route::post('/updateranks', 'AdminController@updateRanks');
Route::post('/addrank', 'AdminController@addRank');
Route::post('/lockthread', 'ForumController@lockThread');
Route::post('/erasepost', 'ForumController@erasePost');
Route::post('/likepost', 'ForumController@likePost');
Route::post('/delthread', 'ForumController@delThread');
Route::post('/postColorUpdate', 'AdminController@postColorUpdate');
Route::post('/postreply', 'ForumController@postReply');
Route::post('/postthread', 'ForumController@postThread');
Route::post('/postcategory', 'ForumController@postCategory');
Route::post('/categoryswitchid', 'ForumController@categorySwitchId');
Route::post('/delcategory', 'ForumController@delCategory');
Route::post('/editcategory', 'ForumController@editCategory');
Route::post('/queryusers', 'AdminController@queryUsers');
Route::post('/querythreads', 'AdminController@queryThreads');
Route::post('/queryposts', 'AdminController@queryPosts');
Route::post('/banuser', 'ForumController@banUser');
Route::post('/markmessagesread', 'ForumController@markMessagesAsRead');
Route::get('/forum/admin', 'AdminController@showCtrlPanel');
Route::get('/forum/admin/datamanagement/ranks', 'AdminController@showRanks');
Route::post('/forum/profile/{user}/edit/updateprofile', 'UserController@updateProfile');
Route::get('/forum/admin/datamanagement/users/{page}', 'AdminController@showUsers');
Route::get('/forum/admin/datamanagement/threads/{page}', 'AdminController@showThreads');
Route::get('/forum/admin/datamanagement/posts/{page}', 'AdminController@showPosts');
Route::get('/forum/admin/datamanagement', 'AdminController@showDataManagement');
Route::get('/forum/profile/{user}', 'ForumController@showUserProfile');
Route::get('/forum/profile/{user}/edit', 'UserController@editProfile');
Route::get('/forum/category/{category}/thread/{thread}/{page}', 'ForumController@showThread');
Route::get('/forum/category/{category}/post', 'ForumController@showThreadPostForm');
Route::get('/forum/category/{category}/{page}', 'ForumController@showCategory');
Route::post('/queryconversation', 'ForumController@queryConversation');
Route::get('/forum', 'ForumController@showCategories');
Auth::routes();
