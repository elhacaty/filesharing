<?php

use Illuminate\Support\Facades\Input as input;
use App\User;

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

Route::get('/', 'HomeController@index');

Route::get('/home', 'HomeController@index');

Route::get('/password-change', 'HomeController@getChangePasswordForm');

Route::post('/password-change', 'HomeController@changePassword');

//PostController

Route::get('/posts', 'PostController@index');

Route::get('/posts/create', 'PostController@create');

Route::post('/posts', 'PostController@store');

Route::post('/like', [
    'uses' => 'PostController@like',
    'as' => 'like'
]);

Route::post('/view_count', [
    'uses' => 'PostController@view_count',
    'as' => 'view_count'
]);

Route::post('/download_count', [
    'uses' => 'PostController@download_count',
    'as' => 'download_count'
]);

Route::get('/posts/likes', 'PostController@likes');

Route::get('/posts/{post}/edit', 'PostController@edit');

Route::get('/posts/liked', 'PostController@liked');

Route::get('/posts/commented', 'PostController@commented');

Route::patch('/posts/{post}/edit', 'PostController@save');

Route::delete('/posts/{post}/delete-post', 'PostController@destroy');



Route::resource('subjects', 'SubjectController');


Route::get('/data/institutes/{id}', 'APIController@getInstituteData');

Route::get('/data/programs/{id}', 'APIController@getProgramData');


Route::post('/posts/{post}/comments', 'CommentController@store');

Route::delete('/posts/{post_id}/{comment_id}/delete-comment', 'CommentController@destroy');

Route::get('/search', 'PostController@search');


Auth::routes();


Route::get('/posts/{post}','PostController@show')->name('posts.show');

