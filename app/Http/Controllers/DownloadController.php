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
		$dt = Carbon::now()->format('dmyhis');
		$tp_id 			= session()->get('open_project');
		$filename 		= $tp_id."_1_".$dt;
  		$data 			= $this->createExcelData($id);
  		$this->processDownload($data, $filename); 
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
		$dt 			= Carbon::now()->format('dmyhis');
		$tp_id 			= session()->get('open_project');
		$filename 		= $tp_id."_1_".$dt;
  		$data 			= $this->createExcelData($id, $filename);
		$this->processDownload($data, $filename); 
		return redirect()->back();
	}

	/*public function download($id)
	{
		$dt 			= Carbon::now()->format('dmyhis');
		$tp_id 			= session()->get('open_project');
		$filename 		= $tp_id."_1_".$dt;
  		$data 			= $this->createExcelData($id);
  		session(['downloaded' => $filename]);
  		$this->processDownload($data, $filename);
	}*/

	public function processDownload($data, $filename)
	{
		if(isset($data['error']))
  		{
  			//In case of error, return with $error messages
          	Toast::message($data['error'], 'danger');          
  		}else
  		{
  			//Download Excel
			Excel::create($filename, function($excel) use($data)  {
				$excel->sheet('Element_sheet',  function($sheet) use($data)  {
		            $sheet->fromArray($data);
	        	});
			})->download('xls');
		}
	}


	public function createExcelData($id, $filename)
	{
		$tp_id =  session()->get('open_project');
		$project = \App\TestProject::find($tp_id);
		$excel_data = [];		
		session(['downloaded' => $filename]);

		if($project->package_name == "")
		{
			$excel_data ['error'] = $this->getMessage('messages.package_error');
		}elseif($project->activity_name == "")
		{
			$excel_data ['error'] = $this->getMessage('messages.activity_error');
		}else{

			$i = 1;
			$case =  \App\TestCase::find($id);
			$sc = \App\TestScenario::find($case->tsc_id);

	  		//Create a test lab for each test case execution
	  		$lab['tl_id'] = $this->genrateRandomInt();  		 
	  		$lab['tp_id'] = $tp_id;	  		
	  		$lab['tc_id'] = $id;
	  		$lab['tf_id'] = $sc->tf_id;
	  		$lab['tsc_id']= $case->tsc_id;	  		
	  		$lab['bug_id'] 			= '';
	  		$lab['tc_status'] 		= 'execute';
	  		$lab['execution_type'] 	= 'autorun';
	  		$lab['executed_by'] 	= session()->get('email');
	  		$lab['executed_by_name']= session()->get('name');
	  		$lab['executed_result'] 	= '';
	  		$lab['checkpoint_result'] 	= '';
	  		$lab['executed_filename'] 	= $filename.".xls";

	  		$c_lab 		=\App\Lab::create($lab);
			$steps 		= \App\TestStep::where(['tc_id'=>$id])->get()->toArray();
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
				$excel_data[] = $data;
			}
		}
		//print_r($excel_data); exit;
		return $excel_data;
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
