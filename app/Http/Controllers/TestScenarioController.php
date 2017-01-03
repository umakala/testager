<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class TestScenarioController extends Controller {

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

		$functionalities = \App\TestFunctionality::where('tp_id' , session()->get('open_project'))->get();

		return view('forms.testscenario', ['functionalities' =>$functionalities]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		//Validations
		$messages = [
		    'tf_id.not_in' => 'The functionality field is required.'
		];
		$validator = \Validator::make($request->all(), array(
			'name' => 'required',
			'tf_id' => 'not_in:none'
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
				$content['tp_id']               	= session()->get('open_project');
				$content['tf_id']               	= $request->tf_id;				
				$content['tsc_id']                 	= $this->genrateRandomInt(3);		
				$content['tsc_name']                = $request->name;
				$content['description']             = $request->description;
		        $content['expected_result']         = $request->expected_result;				
		        $content['status'] 					= $request->status;
			 	$create 							= \App\TestScenario::create($content);
		        return redirect()->route('profile');
		 	}else
		 	{
		 		$error[] = "Session expired. Please login to continue";
		 	}
	 	}
	 	return redirect()->route('scenario.create', ['message' => $error])->withInput();
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
