<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Toast;
use Illuminate\Http\Request;
use App\Http\Controllers\Handlers\DeleteQueryHandler;
use App\Http\Controllers\Handlers\CloneHandler;


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


	public function cloneCase(Request $request)
	{
		//echo 'cloning for '.$request->tsc_id;
		if($request->tc_id == "none")
		{
			$message = $this->getMessage('messages.tc_required');
			Toast::message($message, 'danger');
		}
		else{
			$case = \App\TestCase::find($request->tc_id);
			$new_tc_id 		= $case->tc_id = $request->tsc_id."_".$this->genrateRandomInt();
			$case->tsc_id 	= $request->tsc_id;	
			$case->tp_id 	= session()->get('open_project');
			$case->status 	= 'not_executed';
			\App\TestCase::create($case->toArray());
			if($request->all_teststeps == true){
        		$clone_obj = new CloneHandler();
				$clone_obj->cloneAllSteps($request->tc_id ,$case->tc_id);
			}
			$message = $this->getMessage('messages.clone_success');
			Toast::message($message, 'success');			
			return redirect()->route('testcase.show', ['id' => $new_tc_id]);
		}
		return back();
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
				$content['tc_id']                 	= $request->tsc_id."_".$this->genrateRandomInt();				
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
		       	$content['tc_priority']				= "" ;

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
		$case->steps = \App\TestStep::where(['tc_id' => $id, 'soft_delete' => false])->orderBy('seq_no' , 'asc')->get();
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
			'name' => 'required',
			'seq_no' => 'required'
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
				$content['seq_no'] 					= $request->seq_no;
		        $content['description']             = $request->description;
		        $content['expected_result']         = $request->expected_result;
				$content['tc_priority']            	= $request->priority;
		        $case_update 						= \App\TestCase::find($id);
		        $old_description 					= $case_update->description;
		        $case_update->update($content);

 				if($request->update_level == "project"){
		       		$tp_id = session()->get('open_project');
		        	unset($content['tc_name']);
					unset($content['seq_no']);
		        	\App\TestCase::where(['description' => $old_description, 'tp_id' => $tp_id])->update($content);
		        }

		        $message = $this->getMessage('messages.update_success');
		        Toast::message($message, 'success');

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
        		$del_res = $del_obj->deleteLabByCaseId($id);
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
        }
		else{
			$message = $this->getMessage('messages.delete_failed');
			Toast::message($message, 'danger');
		}
		return redirect()->route('scenario.show', $sc_id);
	}

}
