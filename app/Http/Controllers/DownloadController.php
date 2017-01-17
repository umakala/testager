<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Excel;
use Toast;
use Session;
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

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{	
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$dt 			= Carbon::now()->format('dmyhis');
		$tp_id 			= session()->get('open_project');

		if($id == $tp_id)
		{
			$cases = \App\TestCase::select('tc_id')->where('tp_id', $id)->get()->toArray();
			foreach ($cases as $key => $value) {
				$ids[] = $value['tc_id'];
			}
		}else{
			$ids 			= explode("_",$id,-1);			
		}
		
		$count 			= count($ids);
		$filename 		= $tp_id."_".$count."_".$dt;
		$data 			= $this->createExcelData($ids, $filename);
		session()->save();
		$this->processDownload($data, $filename); 		
		return redirect()->back();
	}
	

  	public function createExcelData($ids, $filename)
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
  			foreach ($ids as $id) {
  				$i++;
  				$case 						= \App\TestCase::find($id);
  				$sc 						= \App\TestScenario::find($case->tsc_id);
	  			//Create a test lab for each test case execution
  				$lab['tl_id'] 				= $this->genrateRandomInt();  		 
  				$lab['tp_id'] 				= $tp_id;	  		
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
	  			$lab['executed_filename'] 	= $filename; //.".xls";

		  		$steps 						= \App\TestStep::where(['tc_id'=>$id])->orderBy('seq_no', 'asc')->get()->toArray();
		  		if(count($steps) > 0)
		  			$c_lab 						=\App\Lab::create($lab);
		  		foreach ($steps as $s_value) {
					//print_r($s_value);
		  			$data['Project Name'] 	= $project->tp_name;
		  			$data['Package Name'] 	= $project->package_name;
		  			$data['Activity Name']	= $project->activity_name;
		  			$data['Description']  	= "";
		  			$data['Test Case'] 		= $i;
		  			$ts_id 					=  $s_value['ts_id'];
		  			$execution 				=  \App\Execution::where(['tc_id' => $id, 'ts_id' => $ts_id])->orderBy('created_at', 'asc')->first();
		  			$data['Scroll'] 		= $execution->scroll;
		  			$data['resource-id'] 	= $execution->resource_id;
		  			$data['text'] 			= $execution->text;
		  			$data['Content-desc'] 	= $execution->content_desc;
		  			$data['class'] 			= $execution->class;
		  			$data['index'] 			= $execution->index;
		  			$data['Sendkey'] 		= $execution->sendkey;	
		  			$data['screenshot'] 	= $execution->screenshot;	
		  			$data['Check point'] 	= $execution->checkpoint;
		  			$data['Wait'] 			= $execution->wait;	
		  			$data['Expected Value'] = $s_value['expected_result'];
		  			$data['e_id'] 			= $execution['e_id'];
		  			$data['tl_id'] 			= $lab['tl_id'];
		  			$excel_data[] 			= $data;
		  		}
		  	}
	  	}
		//print_r($excel_data); exit;
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
