<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class FunctionalityController extends Controller {

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
		//$projects = \App\TestProject::all();
		return view('forms.functionality');//, ['projects' => $projects]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		//Validations
		$validator = \Validator::make($request->all(), array(
			'name' => 'required'
			));
		if ($validator->fails())
		{
			foreach ($validator->errors()->toArray() as $key => $value) {
				$error[]=$value[0];
			} 
		}
		else{
			if( session()->has('email')){
				//Process when validations pass
				$content['tp_id']               	= session()->get('open_project');				
				$content['tf_id']                 	= $this->genrateRandomInt();		
				$content['tf_name']                 = $request->name;
				$content['description']             = $request->description;
		       	$create 							= \App\TestFunctionality::create($content);
		        return redirect()->route('profile');
		 	}else
		 	{
		 		$error[] = "Session expired. Please login to continue";
		 	}
	 	}
	 	return redirect()->route('functionality.create', ['message' => $error])->withInput();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$functionality = \App\TestFunctionality::find($id);
		$project =  \App\TestProject::find($functionality->tp_id);
		$functionality->tp_name  = $project->tp_name;
		$functionality->scenarios = \App\TestScenario::where('tf_id' , $id)->count();

		$cases_id = \App\TestScenario::join('testcases', 
								'testscenarios.tsc_id', '=', 'testcases.tsc_id')
								->where('testscenarios.tf_id', $id)
								->select('testcases.tc_id')
								->get()->toArray();
		$f_cases = array();
		foreach ($cases_id as $key => $value) {
			$f_cases[] = $value['tc_id'];
		}
		$functionality->cases = count($f_cases);
		$functionality->steps = \App\TestCase::join('teststeps', 
								'testcases.tc_id', '=', 'teststeps.tc_id')
								->whereIn('testcases.tc_id', $f_cases)
								->count();

		return view('show.functionality', ['functionality' => $functionality]);
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
