<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Handlers\ChartsHandler;
use App\Http\Controllers\Handlers\ResultUpdateQueryHandler;
use Lava;
use DB;
use Toast;

use Illuminate\Http\Request;

class ReportController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($tf_id = 0)
	{
		$id = session()->get('open_project');
		$project = \App\TestProject::find($id);
		$project->functionalities = \App\TestFunctionality::where('tp_id' , $id)->get();

		foreach ($project->functionalities as $fn) {

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

		if($tf_id <= 0){
			$sc_details = \App\TestScenario::where('tp_id' , $id)->orderBy('seq_no', 'asc')->get();
		}
		else{
			$sc_details = \App\TestScenario::where('tf_id' , $tf_id)->orderBy('seq_no', 'asc')->get();
		}


		foreach ($sc_details as $sc_key => $sc_value) {
		
			//Get details about test cases
			$sc_value->case = \App\TestCase::where(['tp_id' => $id, 'tsc_id' => $sc_value->tsc_id])->orderBy('seq_no', 'asc')->get();
			
			foreach ($sc_value->case as $key => $value) {
				$lab = \App\Lab::where('tc_id' , $value->tc_id)->orderBy('created_at', 'desc')->first();
				$value->lab = $lab;

				$tf = \App\TestFunctionality::select('tf_name')->where('tf_id' , $sc_value->tf_id)->get();
				$value->tf_name = $tf[0]->tf_name;				
			}
		}

		/*if(!session()->has('manual_execution'))
		{*/

			//Initiate chart objects
			$charts_obj = new ChartsHandler();
			$chart_details = $charts_obj->initChartDetails();

			if($tf_id == 0)
				$lab_details = \App\Lab::where('tp_id' , $id)->orderBy('seq_no', 'asc')->get();
			else
				$lab_details = \App\Lab::where('tf_id' , $tf_id)->orderBy('seq_no', 'asc')->get();


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
			

				
			$column_details =[];
			/* 
				Pie Charts showing summary of results 
			*/
			$charts_obj->createExecutionPieChart($chart_details);
			$charts_obj->createCheckpointPieChart($chart_details);
			$charts_obj->createSummaryColumnChart($column_details);
		/*}*/

		return view('reports.report', ['project' => $project, 'lab_results' => $sc_details]);	  	
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function show_scenario($sc_id=0)
	{
		$id = session()->get('open_project');
		$project = \App\TestProject::find($id);
		$project->functionalities = \App\TestFunctionality::where('tp_id' , $id)->get();

		
		//Get details about test cases
		if($sc_id == 0)
			$condition = ['tp_id' => $id ];
		else
			$condition = ['tp_id' => $id, 'tsc_id' => $sc_id ];
		

		//Get details about test cases
		$case = \App\TestCase::where($condition)->orderBy('seq_no', 'asc')->get();
		
		foreach ($case as $key => $c_value) {

			$lab = \App\Lab::where('tc_id' , $c_value->tc_id)->orderBy('created_at', 'desc')->first();
			$c_value->lab = $lab;
			if($lab == null)
			{
				unset($case[$key]);
			}else{
				$tsc = \App\TestScenario::select('tsc_name')->where('tsc_id' , $c_value->tsc_id)->get();
				$c_value->tsc_name = $tsc[0]->tsc_name;

				$tf = \App\TestFunctionality::select('tf_name')->where('tf_id' , $lab->tf_id)->get();
				$c_value->tf_name = $tf[0]->tf_name;
			}
		}



		//Collect details to prepare chart and summary
		$lab_details = \App\Lab::where($condition)->orderBy('seq_no', 'asc')->get();		
		$charts_obj = new ChartsHandler();
		$chart_details = $charts_obj->initChartDetails();

		foreach ($lab_details as $key => $value) {
			
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
		/* 
			Pie Charts showing summary of results 
		*/

		$charts_obj->createExecutionPieChart($chart_details);
		$charts_obj->createCheckpointPieChart($chart_details);

		return view('reports.scenario_report', ['project' => $project, 'lab_results' => $case]);	  	
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
		$lab = \App\Lab::find($id);
		$lab->tc_name = \App\TestCase::select('tc_name')->where('tc_id', $lab->tc_id)->get()[0]['tc_name'];

		return view('forms.edit_result', ['lab' => $lab ]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id,  Request $request)
	{
		$set['executed_by'] = session()->get('email');
		$set['execution_type'] = 'manual';

		if($request->type== 'testlab')
		{
			$set['execution_result'] = $request->execution_result;
			$set['checkpoint_result'] = $request->checkpoint_result;
			$update_obj    = new ResultUpdateQueryHandler();
			$update_result = $update_obj->updateExecutionByLabId($id, $set);
			if($update_result == 1)
			{
				$lab = \App\Lab::find($id)->update($set);
				$message = $this->getMessage('messages.update_success');
				Toast::message($message, 'success');	
			}else{
				$message = $this->getMessage('messages.update_failed');
				Toast::message($message, 'danger');
			}
		}elseif($request->type== 'scenariolab'){

			$set['execution_result'] = $request->result;
			$set['checkpoint_result'] = $request->result;		
			

			$sc_set['executed_by'] = session()->get('email');
			$sc_set['execution_type'] = 'manual';
			$sc_set['result'] = $request->result;


			$update_obj    = new ResultUpdateQueryHandler();
			$update_result = $update_obj->updateLabsByScenarioLabId($id, $set);
			if($update_result == 1)
			{
				$sc_lab = \App\ScenarioLab::find($id)->update($sc_set);
				$message = $this->getMessage('messages.update_success');
				Toast::message($message, 'success');	
			}else{
				$message = $this->getMessage('messages.update_failed');
				Toast::message($message, 'danger');
			}
		}
		return redirect()->back();
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
