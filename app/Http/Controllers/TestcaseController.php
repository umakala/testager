<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Toast;
use Illuminate\Http\Request;
use App\Http\Controllers\Handlers\DeleteQueryHandler;

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
		$message = "";
		$messages = [
		    'tsc_id.not_in' => 'The test scenario selection is required.'
		];
		$validator = \Validator::make($request->all(), array(
			'name' => 'required',
			'tsc_id' => 'not_in:none'        
			), $messages);
		if ($validator->fails())
		{
			foreach ($validator->errors()->toArray() as $key => $value) {
				$message .= $value[0]."\n"; 
			} 
			Toast::message($message, 'danger'); 
		}
		else{
			if( session()->has('email')){
				//Process when validations pass then create test case
				$content['tc_id']                 	= $this->genrateRandomInt();				
				$content['tc_name']                 = $request->name;
				$content['created_by'] 				= session()->get('email');
		        $content['description']             = $request->description;
		        $content['expected_result']         = $request->expected_result;
				$content['status']             		= "not_executed";
		        $content['tp_id']                 	= session()->get('open_project');
		        $content['tsc_id']                 	= $request->tsc_id;	
		        $content['bug_id']					= "";
		       	$content['execution_type']			= "NA" ;
		       	$content['execution_by']			= "" ;
		       	$content_lab['execution_by_name']	= "" ;
		       	$count 								= \App\TestCase::where('tsc_id',  $content['tsc_id'])->count();
		       	$content['seq_no'] 	        		= $count+1;	
		        //$create_lab 						= \App\Lab::create($content_lab);
		        $create 							= \App\TestCase::create($content);

		        //print_r($create); exit;
			 	return redirect()->route('testcase.show', ['id' => $content['tc_id']]);
		 	}else
		 	{
		 		$error[] = "Session expired. Please login to continue";
		 	}
	 	}
		return redirect()->route('testcase.create')->withInput();
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
		$case->steps = \App\TestStep::where('tc_id' , $id)->orderBy('seq_no' , 'asc')->get();
		return view('show.case', ['case' => $case]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$case = \App\TestCase::find($id);
		return view('forms.edit_testcase', ['case' => $case]);

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$validator = \Validator::make($request->all(), array(
			'name' => 'required'
			/*'description' => 'required',
			'expected_result' => 'required'  */   
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
				$content['tc_name']                 = $request->name;
				//$content['created_by'] 			= session()->get('email');
		        $content['description']             = $request->description;
		        $content['expected_result']         = $request->expected_result;
				//$content['status']             		= $request->status;
		        
		        \App\TestCase::find($id)->update($content);
			 	return redirect()->route('testcase.show', ['id' => $id]);
		 	}else
		 	{
		 		$error[] = "Session expired. Please login to continue";
		 	}
	 	}
	 	return redirect()->route('testcase.edit', ['id' => $id, 'message' => $error])->withInput();
		
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
		$item = \App\TestCase::find($id);
		$sc_id = $item->tsc_id;
        if($item){
        	$del_obj = new DeleteQueryHandler();
        	$del_res = $del_obj->deleteStepsByCaseId($id);
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
		return redirect()->route('scenario.show', $sc_id);
	}

}
