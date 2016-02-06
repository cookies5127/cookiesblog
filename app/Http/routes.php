<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/',['as' => 'base', function() {
	return Redirect::to('/index');
}]);

Route::get('home', ['as' => 'home', function() {
	return Redirect::to('/index');
}]);

Route::resource('index', 'IndexController');

Route::group(['prefix' => 'api'], function() {
	Route::resource('posts',	'PostController');
	Route::resource('comments',	'CommentController');
	Route::resource('metas',	'MetasController');
	Route::resource('frags',	'FragmentController');
	Route::resource('books',	'BookController');
	Route::resource('bnotes',	'BookNoteController');
	Route::resource('bpros',	'BookProjectController');
	Route::resource('lessons',	'LessonController');
	Route::resource('sees',		'SeeController');
	Route::resource('wanteds',	'WantedController');
	Route::resource('repos',	'RepoController');
	Route::resource('pros',		'ProjectController');
	Route::resource('prosword',	'ProjectWordController');
	Route::resource('prosthink','ProjectThinkController');
	Route::resource('prosplan',	'ProjectPlanController');
	Route::resource('prosbug',	'ProjectBugController');
	Route::resource('proscheck','ProjectCheckController');
	Route::resource('months',	'MonthController');
	Route::resource('schedules','ScheduleController');
	Route::resource('todos',	'TodolistController');
	Route::resource('thinks',	'ThinkController');
	Route::resource('cates',	'CategoryController' );
	Route::resource('notes',	'NotebookController');

	Route::post('info',function() {
		$data = Input::get('data');
		Mail::raw($data['content'],function($m) use ($data) {
			$m->from($data['email'],$data['name']);
			$m->to('415718598@qq.com');
			$m->subject($data['name']);
		});
		return response()->json($data);;
	});

});

Route::when('auth/*', 'csrf', ['post','delete','put']);

Route::group(['prefix' => 'auth'],function() {
	$Auth = 'Auth\AuthController@';
	Route::get('logout',['as' => 'logout','uses' => $Auth.'getLogout']);
	Route::post('login', $Auth.'postLogin');
});
