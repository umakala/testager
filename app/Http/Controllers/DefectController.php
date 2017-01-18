<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Handlers\ChartsHandler;

use Illuminate\Http\Request;

class DefectController extends Controller {


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$charts_obj = new ChartsHandler();

		$id = session()->get('open_project');
		$project = \App\TestProject::find($id);
		$project->functionalities = \App\TestFunctionality::where('tp_id' , $id)->get();
		
		//Get details about test cases
		$lab_details = \App\Defect::where('tp_id' , $id)->orderBy('created_at', 'asc')->get();
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
		return view('defects.defects', ['project' => $project, 'lab_results' => $lab_details]);	 
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
