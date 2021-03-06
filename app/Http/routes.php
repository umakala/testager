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
Route::get('error', function()
{
	return view('errors.default');
});


//Route::get('/', 'NewsController@index');
Route::get('/', 'UserController@index');
Route::get('/', array( "as"=>"/" , 'uses' =>'UserController@index'));
Route::get('home', array("as"=>"home" , 'uses' =>'UserController@index'));
Route::get('user/register', array("as"=>"user.register" , 'uses' =>'UserController@create'));
Route::post('user/store', array("as"=>"user.store" , 'uses' =>'UserController@store'));
Route::get('user/verify_email', 'UserController@verify_email');
Route::post('reset_password', array("as"=>"reset",'uses' =>'UserController@reset_password'));
Route::post('login', array("as"=>"login" , 'uses' =>'UserController@login'));



//Gaurded Routes
Route::group(['middleware' => 'user'], function () {
Route::get('logout', array("as"=>"logout" , 'uses' =>'UserController@signout'));
Route::get('profile', array("as"=>"profile" , 'uses' =>'UserController@profile'));

Route::resource('news', 'NewsController');
Route::get('news/delete/{id}', array("as"=>"news.delete" , 'uses' =>'NewsController@destroy'));


Route::resource('user','UserController');

Route::get('tree_value/{id}', array("as"=>"tree_value" , 'uses' =>'TreeviewController@index'));
Route::resource('upload','UploadController');
Route::resource('download','DownloadController');
Route::get('format_download/{type}/{id?}', array("as"=>"format_download" , 'uses' =>'DownloadResultFormatController@download'));
Route::get('script_download/{type}/{id?}', array("as"=>"script_download" , 'uses' =>'DownloadController@download'));

Route::resource('upload_result','UploadResultController');

Route::get('execute/process/{id?}', array("as"=>"execute.process" , 'uses' =>'ExecutionController@executeSetup'));

Route::resource('execute','ExecutionController');
Route::resource('report','ReportController');
Route::resource('sc_report','ScenarioReportController');


Route::get('report/sc_lab/{id}', array("as"=>"report.sc_lab" , 'uses' =>'ScenarioReportController@show_lab'));
Route::get('sc_report/functionality/{id?}', array("as"=>"sc_report.functionality" , 'uses' =>'ScenarioReportController@index'));


Route::get('report/lab/{id}', array("as"=>"report.lab" , 'uses' =>'ReportController@show_lab'));
Route::get('report/case/{id}', array("as"=>"report.case" , 'uses' =>'ReportController@show_case'));
Route::get('report/scenario/{id?}', array("as"=>"report.scenario" , 'uses' =>'ReportController@show_scenario'));
Route::get('report/functionality/{id?}', array("as"=>"report.functionality" , 'uses' =>'ReportController@index'));

Route::resource('summary', 'ReportSummaryController');
Route::get('summary/functionality/{id?}', array("as"=>"summary.functionality" , 'uses' =>'ReportSummaryController@index'));

Route::resource('project', 'TestProjectController');
Route::resource('functionality', 'FunctionalityController');
Route::resource('scenario', 'TestScenarioController');
Route::resource('testcase', 'TestcaseController');
Route::resource('teststep', 'TestStepController');

Route::resource('lab', 'TestLabController');
Route::resource('sc_lab', 'ScenarioLabController');

Route::post('lab/create', array("as"=>"lab.create" , 'uses' =>'TestLabController@create'));
Route::get('lab_list/functionality/{id?}', array("as"=>"lab_list.functionality" , 'uses' =>'LabListController@index'));
Route::get('sc_lab_list/functionality/{id?}', array("as"=>"sc_lab_list.functionality" , 'uses' =>'ScenarioLabController@index'));

Route::resource('defect', 'DefectController');
//Route::get('tsc_lab/{tsc_id}', array("as"=>"tsc_lab" , 'uses' =>'TestLabController@showScenario'));

Route::get('tsc_lab/{scl_id}', array("as"=>"tsc_lab" , 'uses' =>'TestLabController@showScenarioLab'));


Route::get('tf_lab/{tf_id}', array("as"=>"tf_lab" , 'uses' =>'TestLabController@showFunctionality'));

Route::post('sc_lab', array("as"=>"sc_lab" , 'uses' =>'TestLabController@store'));
Route::get('manual', array("as"=>"lab.manual" , 'uses' =>'TestLabController@setManualLabSession'));

Route::post('step/reorder/{tc_id}', array("as"=>"step.reorder" , 'uses' =>'TestStepController@reorder'));

Route::get('teststep/create/{tc_id}', array("as"=>"teststep.create" , 'uses' =>'TestStepController@create'));
Route::get('testcase/create/{tsc_id?}', array("as"=>"testcase.create" , 'uses' =>'TestcaseController@create'));

Route::post('testcase/clone', array("as"=>"testcase.clone" , 'uses' =>'TestcaseController@cloneCase'));

Route::post('scenario/clone', array("as"=>"scenario.clone" , 'uses' =>'TestScenarioController@cloneScenario'));

Route::post('functionality/clone', array("as"=>"functionality.clone" , 'uses' =>'FunctionalityController@cloneFunctionality'));


});