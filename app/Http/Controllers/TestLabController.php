<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

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
		return view('testlab.lab', ['project' => $project, 'lab_details' => $lab_details]);	  	
	}

	public function getCountFormat($scenarios_counts)
	{
		$ary['total'] = 0;
		foreach ($scenarios_counts as  $value) {
			switch ($value['status']) {
				case 'failed':
					$ary['failed'] =  $value['count'];
					break;

				case 'passed':
					$ary['passed'] =  $value['count'];
					break;

				case 'not_executed':
					$ary['not_executed'] = $value['count'];
					break;
			}
			$ary['total'] +=  $value['count'];
		}
		return $ary;
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
		$case = \App\TestCase::find($id);
		
		$steps_counts =  \App\TestStep::groupBy('status')->select('status', DB::raw('count(*) as count'))->where("tc_id" , $id)->get();
		
		$case->steps = $this->getCountFormat($steps_counts);
		
		//$lab_details = \App\Lab::where('tp_id' , $id)->get();
		$lab_details = \App\TestStep::where('tc_id' , $id)->orderBy('created_at', 'asc')->get();
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
