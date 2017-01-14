<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use File;
use Illuminate\Http\Request;
use Excel;
use Input;
use Toast;

class UploadController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('forms.upload');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$file 				= $request->file('file');
		$call_page 			= $request->get('call_page');
		$call_page_id 		= $request->get('id');
		
		$ext                = $file->getClientOriginalExtension();
		if($ext == "xls" || $ext == "xlsx"){
			Excel::load(Input::file('file'), function ($reader) use($call_page, $call_page_id) {
				$i=0; $error =false;
				$fn_id = ""; $sc_id ="";  $tc_id =""; $ts_id = "";
				$int_obj = new IntegrationHandler ();
				foreach ($reader->toArray() as $row) {

					switch ($call_page) {
						case 'project':
						$fn_id = $int_obj->handleFunctionality($row, $fn_id);
						/*if($fn_id == 0){
							$error = true; break;
						}*/
	                			//echo " - ";
						case 'functionality':
						if ($call_page == "functionality") {
							$fn_id = $call_page_id;
						}
						echo $sc_id = $int_obj->handleScenario($row, $fn_id, $sc_id);
						/*if($sc_id == 0){
							$error = true; break;
						}*/
		                		//echo " - ";
						case 'scenario':
						if ($call_page == "scenario") {
							$sc_id = $call_page_id;
						}
						echo $tc_id = $int_obj->handleTestcase($row, $sc_id, $tc_id);
						/*if($tc_id == 0){
							$error = true; break;
						}*/
			                	//echo " - ";
						case 'testcase':
						if ($call_page == "testcase") {
							$tc_id = $call_page_id;
						}
						echo $ts_id = $int_obj->handleTeststep($row, $tc_id, $ts_id);
						/*if($ts_id == 0){
							$error = true; break;
						}*/
						echo " <br/> ";
						default:
						break;
					}
					if($error == true)
						break;
				}
				$i++;

			});
			$message = $this->getMessage('messages.upload_success');
			Toast::message($message, 'success');
		}else{
			//echo $error = "Invalid File";
			$message = $this->getMessage('messages.invalid_format');
			Toast::message($message, 'danger');
		}
		return redirect()->back();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


	public function csvMethod($value='')
	{
		# code...
				//if($ext == "csv")
		{
			//$text =  File::get($file->getRealPath());//file_get_contents($file->getRealPath());
			//print_r($file);
			//print_r($text);

		} //else
			//echo "Please provide a csv file.";
	}

}
