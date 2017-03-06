<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Excel;
use Toast;
use Session;
use File;
use Carbon\Carbon;

class DownloadController extends Controller {

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



	public function download($type, $id='')
	{
		$dt 			= Carbon::now()->format('dmyhis');
		$tp_id 			= session()->get('open_project');

		/*if($id == $tp_id)
		{
			$cases = \App\TestCase::select('tc_id')->where('tp_id', $id)->get()->toArray();
			foreach ($cases as $key => $value) {
				$ids[] = $value['tc_id'];
			}
		}else{
			$ids 			= explode($this->getDelimiterChar(),$id,-1);			
		}*/
		
		$count			= \App\Lab::where('scl_id', $id)->count();
		$filename 		= $tp_id."_".$count."_".$dt;
		$data 			= $this->createExcelData($id, $filename);
		session()->save();
		$this->processDownload($data, $filename);
		return redirect()->back();
	}




	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{	
		$dt 			= Carbon::now()->format('dmyhis');
		$tp_id 			= session()->get('open_project');
		$loc 			= session()->get('autorun_location');
		$id 			= $request->tc_ids;
		$page_loc		= $request->autorun;

		if($page_loc == "")
		{
			$message = $this->getMessage('messages.autorun_location_required');
  			Toast::message($message, 'danger'); 
		}elseif(!File::exists($page_loc)){
			$message = $this->getMessage('messages.autorun_location_incorrect');
  			Toast::message($message, 'danger');			
		}else{
			if($page_loc != $loc)
			{
				session()->set('autorun_location' , $page_loc);
				$user_id = session()->get('id');
				$user = \App\User::find($user_id)->update(['autorun_location' => $page_loc]);
			}

			if($id == $tp_id)
			{
				$cases = \App\TestCase::select('tc_id')->where('tp_id', $id)->get()->toArray();
				foreach ($cases as $key => $value) {
					$ids[] = $value['tc_id'];
				}
			}else{
				$ids 			= explode($this->getDelimiterChar(),$id,-1);			
			}
			
			$count 			= count($ids);
			$filename 		= $tp_id."_".$count."_".$dt;
			$data 			= $this->createExcelData($ids, $filename, $request);
			session()->save();
			$this->processDownload($data, $filename); 	
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
		return redirect()->back();
	}
	

  	public function createExcelData($id, $filename)
  	{
  		$tp_id 							=  session()->get('open_project');
  		$project 						= \App\TestProject::find($tp_id);
  		$excel_data 					= [];	
  		session(['downloaded' => $filename]);

  		if($project->package_name == "")
  		{
  			$excel_data ['error'] = $this->getMessage('messages.package_error');
  		}elseif($project->activity_name == "")
  		{
  			$excel_data ['error'] = $this->getMessage('messages.activity_error');
  		}else{
  			$i = 0;
			$case_labs			= \App\Lab::where('scl_id', $id)->orderBy('seq_no', 'asc')->get()->toArray();

  			foreach ($case_labs as $lab) {
  				$i++;
  				$case 						= \App\TestCase::find($lab['tc_id']);
  				$sc 						= \App\TestScenario::find($case->tsc_id);
  				

	  			/*//Create a test lab for each test case execution
  				$lab['tl_id'] 				= $sc_lab['scl_id']."_".$this->genrateRandomInt();
  				$lab['tp_id'] 				= $tp_id;	  
  				$lab['scl_id'] 				= $sc_lab['scl_id'];	
  				$lab['tc_id'] 				= $id;
  				$lab['tf_id'] 				= $sc->tf_id;
  				$lab['tsc_id']				= $case->tsc_id;	  		
  				$lab['bug_id'] 				= '';
  				$lab['tc_status'] 			= 'not_executed';
  				$lab['execution_type'] 		= '';
  				$lab['executed_by'] 		= session()->get('email');
  				$lab['executed_by_name']	= session()->get('name'); 
  				$lab['executed_result'] 	= '';
  				$lab['checkpoint_result'] 	= '';
  				$lab['seq_no']				= $case->seq_no;
	  			$lab['executed_filename'] 	= $filename; //.".xls";
	  			if($request->release == '' || $request->release == null)
	  				$lab['release_version']	= $project->release;
	  			else
	  				$lab['release_version']	= $request->release;
	  			$lab['os_version']			= $request->os_version;
	  			$lab['network_type']		= $request->network_type;
	  			$lab['device_name']			= $request->device_name;*/


  				$executions 				= \App\Execution::where('tl_id', $lab['tl_id'])->orderBy('seq_no', 'asc')->get()->toArray();
		  		//$steps 						= \App\TestStep::where(['tc_id'=>$id])->orderBy('seq_no', 'asc')->get()->toArray();

		  		foreach ($executions as $exe_data) {
					//print_r($s_value);
		  			$data['Project Name'] 	= $project->tp_name;
		  			$data['Package Name'] 	= $project->package_name;
		  			$data['Activity Name']	= $project->activity_name;
		  			$ts_id 					= $exe_data['ts_id'];
		  			$step 					= \App\TestStep::find($ts_id)->toArray();
		  			$data['Description']  	= $step['description'];
					$data['Test Case'] 		= $i;
		  			
		  			/*if(count ($execution) != 0)
					{*/
			  			/*$exe_data 				= $execution[0];
			  			$exe_data['e_id']		= $lab['tl_id']."_".$this->genrateRandomInt(8);
			  			$exe_data['tl_id']		= $lab['tl_id'];
			  			$exe_data['execution_result'] = '';
			  			$exe_data['checkpoint_result'] = '';
			  			unset($exe_data['created_at']);
			  			unset($exe_data['updated_at']);
			  			$created_exe 			= \App\Execution::create($exe_data);*/

			  			$data['Scroll'] 		= $exe_data['scroll'];
			  			$data['resource-id'] 	= $exe_data['resource_id'];
			  			$data['text'] 			= $exe_data['text'];
			  			$data['Content-desc'] 	= $exe_data['content_desc'];
			  			$data['class'] 			= $exe_data['class'];
			  			$data['index'] 			= $exe_data['index'];
			  			$data['Sendkey'] 		= $exe_data['sendkey'];	
			  			$data['screenshot'] 	= $exe_data['screenshot'];	
			  			$data['Check point'] 	= $exe_data['checkpoint'];
			  			$data['Wait'] 			= $exe_data['wait'];
			  			$data['Expected Value'] = $step['expected_result'];
			  			$data['e_id'] 			= $exe_data['e_id'];
			  			$data['tl_id'] 			= $exe_data['tl_id'];
			  			$data['scl_id']			= $id;
			  			$excel_data[] 			= $data;
		  			/*}*/ 	
		  		}
		  	}
	  	}
	  return $excel_data;
	}


	/**
	 * Downlaods the excel from the array given
	 *
	 * @param  $data, $filename
	 * @return null
	 */

  	public function processDownload($data, $filename)
  	{
  		if(isset($data['error']))
  		{
  			//In case of error, return with $error messages
  			Toast::message($data['error'], 'danger');          
  		}else
  		{
  			$message = $this->getMessage('messages.download_success');
  			Toast::message($message, 'succes');          
  			//Download Excel
  			Excel::create($filename, function($excel) use($data)  {
  				$excel->sheet('Element_sheet',  function($sheet) use($data)  {
  					$sheet->fromArray($data);
  				});
  			})->download('xls');
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
