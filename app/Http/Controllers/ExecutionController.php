<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DownloadController;
use Illuminate\Http\Request;
use File;
use Toast;

class ExecutionController extends Controller{

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
	public function store()
	{
		//
	}


	public function executeSetup($id)
	{	
		$filename = "";
		$loc = $this->validatePreRequirements($filename);
		$this->execute($filename, $loc);
		return back();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{	


		$tp_id =  session()->get('open_project');
		$call_from = "";
		if($id == $tp_id)
		{
			$cases = \App\TestCase::select('tc_id')->where('tp_id', $id)->get()->toArray();
			foreach ($cases as $key => $value) {
				$ids[] = $value['tc_id'];
			}
			$call_from = "lab";
		}else{
			$ids 			= explode($this->getDelimiterChar(),$id,-1);			
		}
		
		$cases 			= [];
		$error 			= false;
		$filename = session()->get('downloaded');

		foreach ($ids as $id) { 
			$lab_conditions['tp_id'] 		= $tp_id;
			$lab_conditions['tc_id'] 		= $id;
			$lab_conditions['executed_by'] 	= session()->get('email');
			$lab_conditions['tc_status'] 	= 'not_executed';

			$lab_item = \App\Lab::where($lab_conditions)->orderBy('created_at', 'desc')->first();	
			$result = $this->validatePreRequirements($filename);

			if($lab_item == null)
			{
				/*$message = $this->getMessage('messages.lab_not_found');
				Toast::message($message, 'danger');	
				$error = true;
				break;*/
			}else{
				$filename  = $lab_item->executed_filename;
				if($result != "error"){				
					$lab_item->tc_status = 'executed';
					$lab_item->execution_type = 'autorun';
					$lab_item->save();
					$lab[] = $lab_item;

					$case = \App\Testcase::find($id);
					$case->update(['status'=> 'executed']);
					$cases[] = $case;

					$steps =  \App\TestStep::where('tc_id', $id)->get();
					foreach ($steps as $value) {
						$ex_conditions['tp_id'] 		= $tp_id ;
						$ex_conditions['tc_id'] 		= $id;
						$ex_conditions['ts_id'] 		= $value->ts_id;
						$execution = \App\Execution::where($ex_conditions)->orderBy('created_at', 'asc')->first();
						if($execution != null){
						$execution->executed_by = session()->get('email');
						$execution->executed_by_name = session()->get('name');
						$execution->save();
						$value->status = "executed";
						$value->save();
						}
					}
				}else{
					$error = true;
					break;
				}
			}
		}
		if($filename == null || $filename == "")
		{
			$message = $this->getMessage('messages.xls_not_found');
			Toast::message($message, 'danger');			
		}else if($error == false){
			$this->execute($filename, $result);
		}
		return back();
	}

	public function validatePreRequirements($filename="")
	{
		/*$cmd = 'echo %home%';
		$home = shell_exec($cmd);
		$exe_location  			 	= trim($home)."\Desktop\AutoRun.appref-ms";
		$exe_location_shorcut 		= trim($home)."\Desktop\AutoRun - Shortcut.lnk";
		$exe_location_autorun_shorcut = trim($home)."\Desktop\AutoRun.lnk";	*/	

		/*if(File::exists($exe_location)){
			return $exe_location;		
		}		
		elseif(File::exists($exe_location_shorcut))
		{
			//echo "Found $exe_location_shorcut";
			return $exe_location_shorcut;
		}elseif(File::exists($exe_location_autorun_shorcut))
		{
			return $exe_location_autorun_shorcut;
		}else{
			$message = $this->getMessage('messages.exe_not_found');
			Toast::message($message, 'danger');
			return "error";
		}*/
		
		$exe_location = session()->get('autorun_location');
		return $exe_location;
	}


	public function execute($filename, $exe_location)
	{
		$argument = $filename;
		/*$cmd = 'echo %home%';
		$home = shell_exec($cmd);
		//$exe_location = trim($home)."\Desktop\AutoRun.appref-ms";		
		//echo $exe_location = "C:\Users\sony\Desktop\autorun\app_publish\AutoRun.application";
		//$exe_location = "W:\Work\ATIS\Autorun\AutoRun_code_for_mindgate_HSBC_poc_21_11_2016v06-Copy_share_with_sonu\AutoRun_code_for_mindgate_HSBC_poc_21_11_2016v06-Copy_share_with_sonu\AutoRun\bin\Debug\autorun.exe";
		//$xls_location = trim($home)."\Downloads\\".$filename;
		/*if(File::exists($xls_location.".xls"))
		{
			$xls_location = $xls_location.".xls";
		}elseif(File::exists($xls_location.".xlsx") ){
			$xls_location = $xls_location.".xlsx";
		}else{
			$message = $this->getMessage('messages.xls_not_found');
			Toast::message($message." - $xls_location", 'danger');
		}*/

		if(File::exists($exe_location)){	
			$message = $this->getMessage('messages.execution_start');
			//$message = $message." - ".$filename;
			Toast::message($message, 'info');
			$answer = shell_exec($exe_location);
			//var_dump($answer);
			//echo $argument;			
		}
		else
		{
			//$message = $this->getMessage('messages.exe_not_found');
			$message = $this->getMessage('messages.run_autorun');			
			Toast::message($message, 'info');
		}
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
