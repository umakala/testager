<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Lava;
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

		
		//Get details about test cases
		$lab_details = \App\TestCase::where('tp_id' , $id)->orderBy('seq_no', 'asc')->get();
		$chart_details = $this->initChartDetails();		
	
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

			$chart_details = $this->getChartSummary($chart_value, $chart_details);
		}

		/* 
			Pie Charts showing summary of results 
		*/
		$this->createExecutionPieChart($chart_details);
		$this->createCheckpointPieChart($chart_details);
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
		$p_id = session()->get('open_project');
		$project = \App\TestProject::find($p_id);
		//$project->functionalities = \App\TestFunctionality::where('tp_id' , $id)->count();
		$lab_details = [];
		$chart_details = $this->initChartDetails();
	
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


			$chart_details = $this->getChartSummary($chart_value, $chart_details
				);
		}			
		/* 
			Pie Charts showing summary of results 
		*/

		$this->createExecutionPieChart($chart_details);
		$this->createCheckpointPieChart($chart_details);

		return view('reports.lab_report', ['project' => $project, 'lab_results' => $lab_details]);	  	
	
	}

	public function show_case($id)
	{
		$p_id = session()->get('open_project');
		$project = \App\TestProject::find($p_id);
		//$project->functionalities = \App\TestFunctionality::where('tp_id' , $id)->count();
		$lab_details = [];
		$chart_details = $this->initChartDetails();
	
		//Get details about testlabs
		$lab_details = \App\Execution::where('tl_id' , $id)->orderBy('seq_no', 'asc')->get();
		
		foreach ($lab_details as $key => $value) {
			$step = \App\TestStep::find($value->ts_id);
			$value->step = $step;

			$case = \App\TestCase::find($value->tc_id);
			$value->case = $case;
		
			$tsc = \App\TestScenario::select('tsc_name', 'tf_id')->where('tsc_id' , $case->tsc_id)->get();
			//print_r(); exit;
			$value->tsc_name = $tsc[0]->tsc_name;
			$tf_id = $tsc[0]->tf_id;

			$fn  = \App\TestFunctionality::select('tf_name')->where('tf_id' , $tf_id)->get();
			$value->tf_name = $fn[0]->tf_name;

			if($value->executed_by == '' || $value->executed_by == null)
				$value->ts_status = 'not_executed';
			else
				$value->ts_status = 'executed';
			
			$chart_value['tc_status'] = 	$value->ts_status;
			$chart_value['execution_result'] = $value->execution_result;
			$chart_value['checkpoint_result'] = $value->checkpoint_result;
			$chart_details = $this->getChartSummary($chart_value, $chart_details
				);
		}			
	
		/* 
			Pie Charts showing summary of results 
		*/

		$this->createExecutionPieChart($chart_details);
		$this->createCheckpointPieChart($chart_details);

		return view('reports.case_report', ['project' => $project, 'lab_results' => $lab_details]);	  	
	
	}

	public function initChartDetails()
	{
		$chart_details['ex_pass'] = $chart_details['ex_fail'] = $chart_details['ex_not_avail']  = 0;
		$chart_details['cp_pass'] = $chart_details['cp_fail'] = $chart_details['cp_not_avail']  = 0;
		$chart_details['status_executed'] = $chart_details['status_not_executed'] = 0;
		return $chart_details;
	}

	public function createExecutionPieChart($chart_details)
	{
		$exe_data = Lava::DataTable();
		$exe_data->addStringColumn('Summary')
		        ->addNumberColumn('Percent')
		        ->addRow(['Pass', $chart_details['ex_pass']])
		        ->addRow(['Fail', $chart_details['ex_fail']])
		        ->addRow(['Not Available', $chart_details['ex_not_avail']])
		        ->addRow(['Not Executed', $chart_details['status_not_executed']]);
		Lava::PieChart('exe_result', $exe_data, [
		    'title' => 'Execution Results : Total Executed Labs = '.$chart_details['status_executed'],
		    'colors' => ['#43a047', '#e53935', '#fb8c00', '#1e88e5']
		]);

	}

	public function createCheckpointPieChart($chart_details)
	{
		$cp_data = Lava::DataTable();
		$cp_data->addStringColumn('Summary')
		        ->addNumberColumn('Percent')
		        ->addRow(['Pass', $chart_details['cp_pass']])
		        ->addRow(['Fail', $chart_details['cp_fail']])
		        ->addRow(['Not Available', $chart_details['cp_not_avail']])
		        ->addRow(['Not Executed', $chart_details['status_not_executed']]);
		Lava::PieChart('cp_result', $cp_data, [
		    'title' => 'Checkpoint Results : Total Executed Labs =  '.$chart_details['status_executed'],
		    'colors' => ['#43a047', '#e53935', '#fb8c00', '#1e88e5']
		]);
	}


	public function getChartSummary($value, $chart_details)
	{
		if(strtolower($value['tc_status']) == "executed")
		{
			$chart_details['status_executed']++;
			switch (strtolower($value['execution_result'])) {
				case 'pass':
					$chart_details['ex_pass']++;
					break;
				case 'fail':
					$chart_details['ex_fail']++;
					break;
				case '':				
					$chart_details['ex_not_avail']++;
					break;
			}
			switch (strtolower($value['checkpoint_result'])) {
				case 'pass':
					$chart_details['cp_pass']++;
					break;
				case 'fail':
					$chart_details['cp_fail']++;
					break;
				case '':
					$chart_details['cp_not_avail']++;
					break;
			}
		}
		else
			$chart_details['status_not_executed']++;

		return $chart_details;
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
