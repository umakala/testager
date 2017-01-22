<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Toast;


class TestLabController extends Controller {

/**
 * Display a listing of the resource.
 *
 * @return Response
 */
public function index()
{	
	$id = session()->get('open_project');
	$project = \App\TestProject::find($id);
	$project->functionalities = \App\TestFunctionality::where('tp_id' , $id)->count();
	
	//Query to get TOTAL COUNT
	/*
	$project->scenarios = \App\TestScenario::where('tp_id' , $id)->count();
	$project->cases = \App\TestCase::where('tp_id' , $id)->count();
	$project->steps = \App\TestStep::where('tp_id' , $id)->count();
	*/

	//Group by query to get count according to status 
	$scenarios_counts =  \App\TestScenario::groupBy('status')->select('status', DB::raw('count(*) as count'))->where("tp_id" , $id)->get();

	$cases_counts =  \App\TestCase::groupBy('status')->select('status', DB::raw('count(*) as count'))->where("tp_id" , $id)->get();

	$steps_counts =  \App\TestStep::groupBy('status')->select('status', DB::raw('count(*) as count'))->where("tp_id" , $id)->get();
	
	$project->scenarios = $this->getCountFormat($scenarios_counts);
	$project->cases = $this->getCountFormat($cases_counts);
	$project->steps = $this->getCountFormat($steps_counts);

	//DEBUG
	//return ($project);
	//Get details about test cases
	//$lab_details = [];
	//$lab_details = \App\Lab::where('tp_id' , $id)->get();
	$lab_details = \App\TestCase::where('tp_id' , $id)->orderBy('created_at', 'asc')->get();
	
	foreach ($lab_details as $key => $value) {
		$lab = \App\Lab::where('tc_id' , $value->tc_id)->orderBy('created_at', 'asc')->first();
		$value->lab = $lab;
	}

	return view('testlab.lab', ['project' => $project, 'lab_details' => $lab_details]);	  	
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
	//echo "Welcome to lab store method";
	$lab_cases = [];
	$tc_ids = '';
	$tsc_id = $request->tsc_id;
	$scenario = \App\TestScenario::find($tsc_id);

	if($scenario == null)
	{
		$message = $this->getMessage('messages.something_went_wrong');
		Toast::message($message, 'danger');	
		return redirect()->back();	
	}
	else{
		foreach ($request->except('tsc_id') as $check_key => $check_value) {

			$testcase 	= explode('_', $check_key);
			$id 		= $testcase[1];
			$tc_ids		= $tc_ids.$id."_";
			$case = \App\TestCase::find($id);		
			$steps_counts =  \App\TestStep::groupBy('status')->select('status', DB::raw('count(*) as count'))->where("tc_id" , $id)->get();

			$case->steps = $this->getCountFormat($steps_counts);
			$lab_cases [] = $case;
		}		
		return view('testlab.scenario_lab', ['cases' => $lab_cases, 'scenario' => $scenario , 'tc_ids' => $tc_ids]);
	}	
}


public function createLab($t_id)
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
	$case = \App\TestCase::find($id);
	
	$steps_counts =  \App\TestStep::groupBy('status')->select('status', DB::raw('count(*) as count'))->where("tc_id" , $id)->get();
	
	$case->steps = $this->getCountFormat($steps_counts);
	//$lab_details = \App\Lab::where('tp_id' , $id)->get();
	$lab_details = \App\TestStep::where('tc_id' , $id)->orderBy('seq_no', 'asc')->get();
	foreach ($lab_details as $key => $value) {
		$execution = \App\Execution::where(['ts_id' => $value->ts_id, 'tl_id' => 0])->orderBy('created_at', 'asc')->first();
		$value->execution = $execution;
	}
	//print_r($lab_details[0]);

	//print_r($case);
	//print_r($lab_details[0]->execution->e_id);
	return view('testlab.case_lab', ['case' => $case, 'lab_details' => $lab_details]);
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
