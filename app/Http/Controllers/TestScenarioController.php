<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Handlers\DeleteQueryHandler;
use Toast;

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
		$scenario = \App\TestScenario::find($id);

		$cases = \App\TestCase::where('tsc_id' , $id)->get()->toArray();
		$scenario->cases = count($cases);

		$f_cases = array();
		foreach ($cases as $key => $value) {
			$f_cases[] = $value['tc_id'];
		}

		$scenario->steps = \App\TestCase::join('teststeps', 
								'testcases.tc_id', '=', 'teststeps.tc_id')
								->whereIn('testcases.tc_id', $f_cases)
								->count();
		return view('show.scenario', ['scenario' => $scenario]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$scenario = \App\TestScenario::find($id);
		return view('forms.edit_testscenario', ['scenario' =>$scenario]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
				//Validations
		$validator = \Validator::make($request->all(), array(
			'name' => 'required' ,
			'status' => 'required'        
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
				$content['tsc_name']                = $request->name;
				$content['description']             = $request->description;
		        $content['expected_result']         = $request->expected_result;				
		        
		        \App\TestScenario::find($id)->update($content);
			 	return redirect()->route('scenario.show', ['id' => $id]);
		 	}else
		 	{
		 		$error[] = "Session expired. Please login to continue";
		 	}
	 	}
	 	return redirect()->route('scenario.edit', ['id' => $id, 'message' => $error])->withInput();
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
		$item = \App\TestScenario::find($id);
		$tf_id = $item->tf_id;
        if($item){
        	$del_obj = new DeleteQueryHandler();
        	$del_res = $del_obj->deleteCaseByScenarioId($id);
			if($del_res == 0)
			{
				$message = $this->getMessage('messages.delete_failed');
				Toast::message($message, 'danger');
			}  else{      	
	        	//Delete testcase
	        	$item->delete();
				$message = $this->getMessage('messages.delete_success');
				Toast::success($message);
			}
        }
		else{
			$message = $this->getMessage('messages.delete_failed');
			Toast::message($message, 'danger');
		}
		return redirect()->route('functionality.show', $tf_id);
	}

}
