<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class TestcaseController extends Controller {

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
		//$functionalities = \App\TestFunctionality::();
		$scenarios = \App\TestScenario::where('tp_id' , session()->get('open_project'))->get();		
		foreach ($scenarios as $key => $value) {
			$functionality =  \App\TestFunctionality::find($value->tf_id);
			$value->tf_name = $functionality->tf_name;
		}

		return view('forms.testcase',['scenarios' => $scenarios]);	
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$messages = [
		    'tf_id.not_in' => 'The Scenario field is required.'
		];
		$validator = \Validator::make($request->all(), array(
			'name' => 'required',
			'tsc_id' => 'not_in:none'        
			), $messages);
		if ($validator->fails())
		{
			foreach ($validator->errors()->toArray() as $key => $value) {
				$error[]=$value[0];
			} 
		}
		else{
			if( session()->has('email')){
				//Process when validations pass
				$content['tc_id']                 	= $this->genrateRandomInt();				
				$content['tc_name']                 = $request->name;
				//$content['created_by'] 			= session()->get('email');
		        $content['description']             = $request->description;
		        $content['expected_result']         = $request->expected_result;
				$content['status']             		= $request->status;
		        $content['tp_id']                 	= session()->get('open_project');
		        $content['tsc_id']                 	= $request->tsc_id;
				
		        $create 							= \App\TestCase::create($content);
		        //return redirect()->route('profile', ['message' => ""]);
			 	return redirect()->route('profile');
		 	}else
		 	{
		 		$error[] = "Session expired. Please login to continue";
		 	}
	 	}
	 	return redirect()->route('testcase.create', ['message' => $error])->withInput();
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
