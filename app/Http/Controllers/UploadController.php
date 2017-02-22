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

		if($file == null)
		{
			$message = $this->getMessage('messages.file_required');
			Toast::message($message, 'danger');
		}
		else{
			$ext                = $file->getClientOriginalExtension();
			if($ext == "xls" || $ext == "xlsx"){
				Excel::load(Input::file('file'), function ($reader) use($call_page, $call_page_id) {
					try{
					$i=0; $error =false; $seq = 1;  $tc_seq = 1; $sc_seq = 1;  
					$fn_id = ""; $sc_id ="";  $tc_id =""; $ts_id = "";

					//Create object of IntegrationHandler class to access methods to process conversion of xls to db format
					$int_obj = new IntegrationHandler();
					$reader_ary = $reader->toArray();
					if(isset($reader_ary[0][0]))
					{
						$reader_ary = $reader_ary[0];
					}

					//print_r($reader_ary);exit;
					foreach ($reader_ary as $row) {
						switch ($call_page) {
							//When upload method is called from project page to upload functionality and lower levels
							case 'project':
							if(isset($row['functionality_name']))
								$fn_id = $int_obj->handleFunctionality($row, $fn_id);
							/*if($fn_id == 0){
								$error = true; break;
							}*/
		                	
							//When upload method is called from functionality page to upload scenario to functionality with id as call_page_id and lower levels
							case 'functionality':
							if ($call_page == "functionality") {
								$fn_id = $call_page_id;
							}
							if(isset($row['sceanrio_name'])){
								$sc_id = $int_obj->handleScenario($row, $fn_id, $sc_id, $sc_seq);
								$sc_seq++;
							}
							/*if($sc_id == 0){
								$error = true; break;
							}*/

							//When upload method is called from scenario page to upload testcases and teststeps to scenario with id as call_page_id

							case 'scenario':
							if ($call_page == "scenario") {
								$sc_id = $call_page_id;
							}
							if(isset($row['sceanrio_name'])){
								$tc_seq = 1;
							}
							if(isset($row['test_case_name'])){
								$tc_id = $int_obj->handleTestcase($row, $sc_id, $tc_id, $tc_seq);
								$tc_seq++;
							}
							/*if($tc_id == 0){
								$error = true; break;
							}*/

							//When upload method is called from testcase page to upload teststeps to call_page_id testase
							case 'testcase':
							if ($call_page == "testcase") {
								$tc_id = $call_page_id;
							}
							if(isset($row['testcase'])){
								$seq = 1;
							}
							if(isset($row['test_step']))
								$ts_id = $int_obj->handleTeststep($row, $tc_id, $ts_id, $seq);
							/*if($ts_id == 0){
								$error = true; break;
							}*/
							
							//echo " <br/> ";
							$seq++;
							break;

							//When upload method is called from testcase page to upload teststeps with execution format xls to call_page_id testase. New teststesp are created, each corresponding to the row of execution xls file
							case 'teststep':
							if ($call_page == "teststep") {
								$tc_id = $call_page_id;
							}
							//if(isset($row['test_step'])
							//echo "Handling row<br/>";
							$ts_id = $int_obj->handleExecution($row, $tc_id, $ts_id, $seq);
							if($ts_id == 0)
							{
								$message = $this->getMessage('messages.description_required');
        						Toast::message($message, 'danger');
        						$error =true;
        						break;
							}
							$seq++;
							default:
							break;
						}
						if($error == true)
							break;
					}
				
					$i++;
					}catch(Exception $e){
						$message = $this->getMessage('messages.upload_failed');
						Toast::message($message, 'danger');
					}
					if($error == false)
					{
						$message = $this->getMessage('messages.upload_success');
						Toast::message($message, 'success');
					}
				});
				$message = $this->getMessage('messages.upload_completed');
				Toast::message($message, 'info');
			}else{
				//echo $error = "Invalid File";
				$message = $this->getMessage('messages.invalid_format');
				Toast::message($message, 'danger');
			}
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


	public function downloadDetails($call_page, $call_page_id)
	{	
		try{
		$i=0; $error =false; $seq = 1;  $tc_seq = 1; $sc_seq = 1;  
		$fn_id = ""; $sc_id ="";  $tc_id =""; $ts_id = "";

		//Create object of IntegrationHandler class to access methods to process conversion of db to xls format

		$int_obj = new IntegrationHandler();
		switch ($call_page) {
				//When download method is called from project page to download functionality and lower levels
				case 'project':
					$fn_id = $int_obj->handleFunctionalityDbtoXlS($call_page_id);
			

				//When upload method is called from functionality page to upload scenario to functionality with id as call_page_id and lower levels
				case 'functionality':
				if ($call_page == "functionality") {
					$fn_id = $call_page_id;
				}
				if(isset($row['sceanrio_name'])){
					$sc_id = $int_obj->handleScenario($row, $fn_id, $sc_id, $sc_seq);
					$sc_seq++;
				}
				/*if($sc_id == 0){
					$error = true; break;
				}*/

				//When upload method is called from scenario page to upload testcases and teststeps to scenario with id as call_page_id

				case 'scenario':
				if ($call_page == "scenario") {
					$sc_id = $call_page_id;
				}
				if(isset($row['sceanrio_name'])){
					$tc_seq = 1;
				}
				if(isset($row['test_case_name'])){
					$tc_id = $int_obj->handleTestcase($row, $sc_id, $tc_id, $tc_seq);
					$tc_seq++;
				}
				/*if($tc_id == 0){
					$error = true; break;
				}*/

				//When upload method is called from testcase page to upload teststeps to call_page_id testase
				case 'testcase':
				if ($call_page == "testcase") {
					$tc_id = $call_page_id;
				}
				if(isset($row['testcase'])){
					$seq = 1;
				}
				if(isset($row['test_step']))
					$ts_id = $int_obj->handleTeststep($row, $tc_id, $ts_id, $seq);
				/*if($ts_id == 0){
					$error = true; break;
				}*/
				
				//echo " <br/> ";
				$seq++;
				break;

				//When upload method is called from testcase page to upload teststeps with execution format xls to call_page_id testase. New teststesp are created, each corresponding to the row of execution xls file
				case 'teststep':
				if ($call_page == "teststep") {
					$tc_id = $call_page_id;
				}
				//if(isset($row['test_step'])
				//echo "Handling row<br/>";
				$ts_id = $int_obj->handleExecution($row, $tc_id, $ts_id, $seq);
				if($ts_id == 0)
				{
					$message = $this->getMessage('messages.description_required');
					Toast::message($message, 'danger');
					$error =true;
					break;
				}
				$seq++;
				default:
				break;
			}
			if($error == true)
				break;
		}catch(Exception $e){
			$message = $this->getMessage('messages.upload_failed');
			Toast::message($message, 'danger');
		}
		if($error == false)
		{
			$message = $this->getMessage('messages.upload_success');
			Toast::message($message, 'success');
		}
	$message = $this->getMessage('messages.upload_completed');
	Toast::message($message, 'info');

		
		return redirect()->back();
	}

}
