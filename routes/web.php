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

/******** Admin panel ********/
Route::group(
	[
		'prefix' => 'admin',
		'namespace' => 'Admin',
		'middleware' => 'moderator',
		'as' => 'admin.',
	],
	function () {

		/**** Users ****/
		Route::resource('users', 'UserController')
			->except('show')
			->names('users');

		Route::group(['prefix' => 'user', 'as' => 'users.'], function () {

			Route::get('{user}/info', 'UserController@info')
				->name('info');

			Route::get('{user}/questions', 'UserController@questions')
				->name('questions');

			Route::get('{user}/answers', 'UserController@answers')
				->name('answers');

			Route::get('{user}/comments', 'UserController@comments')
				->name('comments');
		});

		/**** Tags ****/
		Route::resource('tags', 'TagController')
			->except('show')
			->names('tags');

		Route::group(['prefix' => 'tag', 'as' => 'tags.'], function () {

			Route::get('{tag}/info', 'TagController@info')
				->name('info');

			Route::get('{tag}/questions', 'TagController@questions')
				->name('questions');

			Route::post('{tag}/restore', 'TagController@restore')
				->name('restore');
		});

		/**** Questions ****/
		Route::resource('questions', 'QuestionController');

		Route::post('questions/{question}/restore', 'QuestionController@restore')
			->name('questions.restore');

		/**** Answers ****/
		Route::resource('answers', 'AnswerController')
			->only('index', 'store', 'edit', 'update', 'destroy')
			->names('answers');

		Route::post('answers/{answer}/restore', 'AnswerController@restore')
			->name('answers.restore');

		Route::get('answers/{answer}/change_status',
			'AnswerController@change_status')
			->name('answers.change_status');

		/**** Comments ****/
		Route::resource('comments', 'CommentController')
			->only('index', 'edit', 'update', 'destroy')
			->names('comments');

		Route::post('comments/{comment}/restore', 'CommentController@restore')
			->name('comments.restore');
});

/******** Public ********/

/**** Users ****/
Route::resource('users', 'UserController')
	->except('show')->names('users');

/** User`s Profile routes **/
Route::group(['prefix' => 'user', 'as' => 'users.'], function () {

	Route::get('{user}/info', 'UserController@info')
		->name('info');

	Route::get('{user}/questions', 'UserController@questions')
		->name('questions');

	Route::get('{user}/answers', 'UserController@answers')
		->name('answers');

	Route::get('{user}/comments', 'UserController@comments')
		->name('comments');
});

/**** Tags ****/
Route::resource('tags', 'TagController')
	->except('show')
	->names('tags');

/** Tag`s profile routes **/
Route::group(['prefix' => 'tag', 'as' => 'tags.'], function () {

	Route::get('{tag}/info', 'TagController@info')
		->name('info');

	Route::get('{tag}/questions', 'TagController@questions')
		->name('questions');

	Route::post('{tag}/restore', 'TagController@restore')
		->name('restore');
});

/**** Questions ****/
Route::resource('questions', 'QuestionController');

/** Store comment for question **/
Route::post('questions/{question}/question/comment',
	'CommentController@storeForQuestion')
	->name('comments.storeForQuestion');

/** Store comment for answer **/
Route::post('questions/{question}/answer/comment',
	'CommentController@storeForAnswer')
	->name('comments.storeForAnswer');

/**** Answers ****/
Route::resource('answers', 'AnswerController')
	->only('index', 'store', 'edit', 'update', 'destroy')
	->names('answers');

Route::get('answers/{answer}/change_status',
	'AnswerController@changeStatus')
	->name('answers.changeStatus');

/**** Comments ****/
Route::resource('comments', 'CommentController')
	->only('index', 'edit', 'update', 'destroy')
	->names('comments');