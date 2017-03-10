<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Handlers\DeleteQueryHandler;

use Illuminate\Http\Request;
use DB;
use Toast;

class ScenarioLabController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($tf_id=0)
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
			//Get details about Scenario Lab
			$sc_value->lab = \App\ScenarioLab::where(['tp_id' => $id, 'tsc_id' => $sc_value->tsc_id])->orderBy('created_at', 'desc')->first();	

			if($sc_value->lab == null)
			{
				unset($sc_details[$sc_key]);
			}else{
			//Get details about test cases
			$sc_value->case = \App\TestCase::where(['tp_id' => $id, 'tsc_id' => $sc_value->tsc_id])->orderBy('seq_no', 'asc')->get();
			
			foreach ($sc_value->case as $key => $value) {
				$lab = \App\Lab::where('tc_id' , $value->tc_id)->orderBy('created_at', 'desc')->first();
				$value->lab = $lab;

				$tf = \App\TestFunctionality::select('tf_name')->where('tf_id' , $sc_value->tf_id)->get();
				$value->tf_name = $tf[0]->tf_name;	
				}			
			}
		}

		/*if(!session()->has('manual_execution'))
		{*/

			if($tf_id == 0)
				$lab_details = \App\Lab::where('tp_id' , $id)->orderBy('seq_no', 'asc')->get();
			else
				$lab_details = \App\Lab::where('tf_id' , $tf_id)->orderBy('seq_no', 'asc')->get();


			foreach ($lab_details as $key => $value) {

				$tc = \App\TestCase::find($value->tc_id);
				$value->tc = $tc;

				$tsc = \App\TestScenario::select('tsc_name')->where('tsc_id' , $value->tsc_id)->get();
				$value->tsc_name = $tsc[0]->tsc_name;
			}
			

		return view('testlab.sc_lab_list', ['project' => $project, 'lab_results' => $sc_details]);
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
		$tp_id = session()->get('open_project');
		$project = \App\TestProject::find($tp_id);

		$lab = \App\ScenarioLab::find($id);
		$sc_details = \App\TestScenario::find($lab->tsc_id);
		$sc_details->lab = $lab;
		

		$lab_details = \App\Lab::where('scl_id' , $id)->orderBy('seq_no', 'asc')->get();
		foreach ($lab_details as $key => $value) {

			$tc = \App\TestCase::find($value->tc_id);
			$value->case = $tc;
			$value->case->steps = \App\TestStep::where(['tc_id' => $value->tc_id, 'soft_delete' => false])->orderBy('seq_no', 'asc')->get();	
			/*
			$tsc = \App\TestScenario::select('tsc_name')->where('tsc_id' , $value->tsc_id)->get();
			$value->tsc_name = $tsc[0]->tsc_name;*/
		}

		//$sc_details->case_labs = $lab_details;
		return view('testlab.show_sc_lab', ['labs' => $lab_details, 'scenario' => $sc_details]);
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
		$tp_id = session()->get('open_project');
		$item = \App\ScenarioLab::find($id);
		if($item){
	        //Delete testlabs and execution steps
        	$del_obj = new DeleteQueryHandler();
        	$del_res = $del_obj->deleteLabByScLabId($id);
			if($del_res == 0)
			{
				$message = $this->getMessage('messages.delete_failed');
				Toast::message($message, 'danger');
			}  else{      	
	        		$item->delete();
					$message = $this->getMessage('messages.delete_success');
					Toast::success($message);
			}
        }
		else{
			$message = $this->getMessage('messages.delete_failed');
			Toast::message($message, 'danger');
		}
		return redirect()->route('sc_lab.index');
	}

}
