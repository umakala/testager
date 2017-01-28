<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Handlers\ChartsHandler;
use Lava;
use DB;

use Illuminate\Http\Request;

class ReportController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$id = session()->get('open_project');
		$project = \App\TestProject::find($id);
		$project->functionalities = \App\TestFunctionality::where('tp_id' , $id)->get();

		foreach ($project->functionalities as $fn) {
			/*$scenarios_counts =  \App\TestScenario::groupBy('status')->select('status', DB::raw('count(*) as count'))->where("tp_id" , $id)->get();*/
			/*$cases_counts 	=  \App\Lab::groupBy('execution_result')
									->select('execution_result', DB::raw('count(*) as count'))
									->where("tf_id" , $fn->tf_id)
									->get();*/


			$cases_counts 	=  \App\Lab::groupBy('execution_result')
									->select('execution_result', DB::raw('count(*) as count'))
									->where("tf_id" , $fn->tf_id)
									->get();

			$steps_counts  	= \App\Execution::join('labs', 
								'labs.tc_id', '=', 'executions.tc_id')
								->select('executions.execution_result', DB::raw('count(*) as count'))
								->where('labs.tf_id', $fn->tf_id)
								->where('executions.tl_id' , '<>' , '0')
								->groupBy('executions.execution_result')
								->get()->toArray();

			//$fn->scenarios 		= $this->getCountFormat($scenarios_counts);
			$fn->testcases = $this->getCountFormatLabs($cases_counts,'execution_result' );
			$fn->teststeps = $this->getCountFormatLabs($steps_counts, 'execution_result');
		}

		//Initiate chart objects
		$charts_obj = new ChartsHandler();
		$chart_details = $charts_obj->initChartDetails();

		$lab_details = \App\Lab::where('tp_id' , $id)->orderBy('seq_no', 'asc')->get();

		foreach ($lab_details as $key => $value) {

			$tc = \App\TestCase::find($value->tc_id);
			$value->tc = $tc;

			$tsc = \App\TestScenario::select('tsc_name')->where('tsc_id' , $value->tsc_id)->get();
			$value->tsc_name = $tsc[0]->tsc_name;

			if(isset($value->tf_id))
			{
				$fn  = \App\TestFunctionality::select('tf_name')->where('tf_id' , $value->tf_id)->get();
				$value->tf_name = $fn[0]->tf_name;
				$chart_value['tc_status'] 			= 'executed';
				$chart_value['execution_result'] 	= $value->execution_result;
				$chart_value['checkpoint_result'] 	= $value->checkpoint_result;
			}else{
				$value->tf_name = "";
				$chart_value['tc_status'] = $value->status;
				$chart_value['execution_result'] = 0;
				$chart_value['checkpoint_result'] = 0;
			}
			$chart_details = $charts_obj->getChartSummary($chart_value, $chart_details);
		}
		
		//Get details about test cases
		$case_details = \App\TestCase::where('tp_id' , $id)->orderBy('seq_no', 'asc')->get();	

		foreach ($case_details as $key => $value) {
			$lab = \App\Lab::where('tc_id' , $value->tc_id)->orderBy('created_at', 'desc')->first();
			$value->lab = $lab;

			$tsc = \App\TestScenario::select('tsc_name')->where('tsc_id' , $value->tsc_id)->get();
			$value->tsc_name = $tsc[0]->tsc_name;

			/*if(isset($lab->tf_id))
			{
				$fn  = \App\TestFunctionality::select('tf_name')->where('tf_id' , $lab->tf_id)->get();
				$value->tf_name = $fn[0]->tf_name;
				$chart_value['tc_status'] 			= $value->status;
				$chart_value['execution_result'] 	= $value->lab->execution_result;
				$chart_value['checkpoint_result'] 	= $value->lab->checkpoint_result;
			}else{
				$value->tf_name = "";
				$chart_value['tc_status'] = $value->status;
				$chart_value['execution_result'] = 0;
				$chart_value['checkpoint_result'] = 0;
			}
			$chart_details = $charts_obj->getChartSummary($chart_value, $chart_details);*/
		}

		$column_details =[];
		/* 
			Pie Charts showing summary of results 
		*/
		$charts_obj->createExecutionPieChart($chart_details);
		$charts_obj->createCheckpointPieChart($chart_details);
		$charts_obj->createSummaryColumnChart($column_details);

		return view('reports.functionality_report', ['project' => $project, 'lab_results' => $case_details]);	  	
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function show_scenario()
	{
		$id = session()->get('open_project');
		$project = \App\TestProject::find($id);
		$project->functionalities = \App\TestFunctionality::where('tp_id' , $id)->get();

		$charts_obj = new ChartsHandler();
		
		//Get details about test cases
		$lab_details = \App\TestCase::where('tp_id' , $id)->orderBy('seq_no', 'asc')->get();
		$chart_details = $charts_obj->initChartDetails();		
	
		foreach ($lab_details as $key => $value) {
			$lab = \App\Lab::where('tc_id' , $value->tc_id)->orderBy('created_at', 'desc')->first();
			$value->lab = $lab;
			
			$tsc = \App\TestScenario::select('tsc_name')->where('tsc_id' , $value->tsc_id)->get();
			$value->tsc_name = $tsc[0]->tsc_name;

			$fn  = \App\TestFunctionality::select('tf_name')->where('tf_id' , $lab->tf_id)->get();
			$value->tf_name = $fn[0]->tf_name;

			$chart_value['tc_status'] = $value->status;
			$chart_value['execution_result'] = $value->lab->execution_result;
			$chart_value['checkpoint_result'] = $value->lab->checkpoint_result;

			$chart_details = $charts_obj->getChartSummary($chart_value, $chart_details);
		}

		/* 
			Pie Charts showing summary of results 
		*/
		$charts_obj->createExecutionPieChart($chart_details);
		$charts_obj->createCheckpointPieChart($chart_details);
		return view('reports.scenario_report', ['project' => $project, 'lab_results' => $lab_details]);	  	
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

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show_lab($id)
	{

		$charts_obj = new ChartsHandler();


		$p_id = session()->get('open_project');
		$project = \App\TestProject::find($p_id);
		//$project->functionalities = \App\TestFunctionality::where('tp_id' , $id)->count();
		$lab_details = [];
		$chart_details = $charts_obj->initChartDetails();

	
		//Get details about testlabs
		$lab_details = \App\Lab::where('tc_id' , $id)->orderBy('created_at', 'desc')->get();
		foreach ($lab_details as $key => $value) {
			$case = \App\TestCase::where('tc_id' , $value->tc_id)->get();
			$value->case = $case;
		
			$tsc = \App\TestScenario::select('tsc_name')->where('tsc_id' , $value->tsc_id)->get();
			$value->tsc_name = $tsc[0]->tsc_name;
			
			$fn  = \App\TestFunctionality::select('tf_name')->where('tf_id' , $value->tf_id)->get();
			$value->tf_name = $fn[0]->tf_name;

			$chart_value['tc_status'] = $value->tc_status;
			$chart_value['execution_result'] = $value->execution_result;
			$chart_value['checkpoint_result'] = $value->checkpoint_result;


			$chart_details = $charts_obj->getChartSummary($chart_value, $chart_details
				);
		}			
		/* 
			Pie Charts showing summary of results 
		*/

		$charts_obj->createExecutionPieChart($chart_details);
		$charts_obj->createCheckpointPieChart($chart_details);

		return view('reports.lab_report', ['project' => $project, 'lab_results' => $lab_details]);	  	
	
	}

	public function show_case($id)
	{

		$charts_obj = new ChartsHandler();
		 
		$p_id = session()->get('open_project');
		$project = \App\TestProject::find($p_id);
		//$project->functionalities = \App\TestFunctionality::where('tp_id' , $id)->count();
		$chart_details = $charts_obj->initChartDetails();

		//Get details about execution of associated test lab
		$execution_details = \App\Execution::where('tl_id' , $id)->orderBy('seq_no', 'asc')->get();
		$execution_details->lab = \App\Lab::find($id);
		
		$case = \App\TestCase::find($execution_details->lab->tc_id);
		$execution_details->case = $case;

		$tsc = \App\TestScenario::select('tsc_name', 'tf_id')->where('tsc_id' , $case->tsc_id)->get();
		$execution_details->tsc_name = $tsc[0]->tsc_name;
		$tf_id = $tsc[0]->tf_id;

		$fn  = \App\TestFunctionality::select('tf_name')->where('tf_id' , $tf_id)->get();
		$execution_details->tf_name = $fn[0]->tf_name;
		
		foreach ($execution_details as $key => $value) {
			$step = \App\TestStep::find($value->ts_id);
			$value->step = $step;			

			if($value->execution_result == '' || $value->execution_result == null){
				$value->ts_status = 'not_executed';
				//echo "case not_executed , ";
			}
			else
				$value->ts_status = 'executed';
			
			$chart_value['tc_status'] = 	$value->ts_status;
			$chart_value['execution_result'] = $value->execution_result;
			$chart_value['checkpoint_result'] = $value->checkpoint_result;
			$chart_details = $charts_obj->getChartSummary($chart_value, $chart_details
				);
		}			
	
		/* 
			Pie Charts showing summary of results 
		*/
		$charts_obj->createExecutionPieChart($chart_details);
		$charts_obj->createCheckpointPieChart($chart_details);

		return view('reports.case_report', ['project' => $project, 'execution_results' => $execution_details]);	  	
	
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
