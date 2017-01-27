<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Excel;
use Input;
use Toast;
use File;

class UploadResultController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
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

		if($file == null)
		{
			$message = $this->getMessage('messages.file_required');
			Toast::message($message, 'danger');
		}
		else{
			$ext                = $file->getClientOriginalExtension();
			if($ext == "xls" || $ext == "xlsx"){
				Excel::load(Input::file('file'), function ($reader) {
					try{

					$error =false;
					//Create object of IntegrationHandler class to access methods to process conversion of xls to db format
					$int_obj = new IntegrationHandler();

					$reader_ary = $reader->toArray();
					if(isset($reader_ary[0][0]))
					{
						$reader_ary = $reader_ary[0];
					}

					$sc_result = ""; $tc_result = ""; $ts_result = "";
					$email = session()->get('email');

					foreach ($reader_ary as $row) {
						//print_r($row); exit;
						if(isset($row['scenario_id'])){
							$sc_result = $row['scenario_result'];
							if($sc_result == "")
								$sc_result = "not_executed";
							$update_sc = [ 'result' => $sc_result, 
											'execution_type' => 'manual',
											'execution_by' => $email ];
							\App\ScenarioLab::find($row['scenario_id'])->update($update_sc);
						}
						if(isset($row['test_case_id'])){
							if(isset($row['case_result']) && ($row['case_result']) != ""){
								$tc_result = $row['case_result'];
							}else
							{
								 $tc_result = $sc_result;
							}
							$update_case = [ 'execution_result' => 'Pass' , 
											 'checkpoint_result' =>  $tc_result, 
											 'tc_status' => 'executed',  
											 'execution_type' => 'manual', 
											 'execution_by' => $email, 
											 'execution_by_name' => $email];
							\App\Lab::find($row['test_case_id'])->update($update_case);
						}

						if(isset($row['test_step_id'])){
							if(isset($row['step_result']) && ($row['step_result']) != ""){
								$step_result = $row['step_result'];
							}else
							{
								$step_result = $tc_result;
							}
							$update_step = ['execution_result' => 'Pass' , 
											 'checkpoint_result' =>  $step_result, 
											 'execution_by' => $email, 
											 'execution_by_name' => $email];				
							\App\Execution::find($row['test_step_id'])->update($update_step);
						}
					}
				
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

}
