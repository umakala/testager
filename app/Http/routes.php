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


//Route::get('/', 'NewsController@index');
Route::get('/', array( "as"=>"/" , 'uses' =>'UserController@index'));
Route::get('home', array("as"=>"home" , 'uses' =>'UserController@index'));
Route::get('user/register', array("as"=>"user.register" , 'uses' =>'UserController@create'));
Route::post('store', array("as"=>"store" , 'uses' =>'UserController@store'));
Route::get('user/verify_email', 'UserController@verify_email');
Route::post('reset_password', array("as"=>"reset",'uses' =>'UserController@reset_password'));

Route::post('login', array("as"=>"login" , 'uses' =>'UserController@login'));



//Gaurded Routes
Route::group(['middleware' => 'user'], function () {
Route::get('logout', array("as"=>"logout" , 'uses' =>'UserController@signout'));
Route::get('profile', array("as"=>"profile" , 'uses' =>'UserController@profile'));

Route::resource('news', 'NewsController');
Route::get('news/delete/{id}', array("as"=>"news.delete" , 'uses' =>'NewsController@destroy'));

Route::get('tree_value/{id}', array("as"=>"tree_value" , 'uses' =>'TreeviewController@index'));
Route::resource('upload','UploadController');
Route::resource('download','DownloadController');

Route::resource('execute','ExecutionController');
Route::resource('report','ReportController');
Route::get('report/lab/{id}', array("as"=>"report.lab" , 'uses' =>'ReportController@show_lab'));
Route::get('report/case/{id}', array("as"=>"report.case" , 'uses' =>'ReportController@show_case'));


Route::resource('project', 'TestProjectController');
Route::resource('functionality', 'FunctionalityController');
Route::resource('scenario', 'TestScenarioController');
Route::resource('testcase', 'TestcaseController');
Route::resource('teststep', 'TestStepController');

Route::resource('lab', 'TestLabController');
Route::resource('defect', 'DefectController');

Route::post('sc_lab', array("as"=>"sc_lab" , 'uses' =>'TestLabController@store'));
Route::post('step/reorder/{tc_id}', array("as"=>"step.reorder" , 'uses' =>'TestStepController@reorder'));
Route::get('teststep/create/{tc_id}', array("as"=>"teststep.create" , 'uses' =>'TestStepController@create'));
});