<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Handlers\DeleteQueryHandler;
use App\Http\Controllers\Handlers\CloneHandler;

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

	public function cloneScenario(Request $request)
	{
		//echo 'cloning for '.$request->tsc_id;
		if($request->tsc_id == "none")
		{
			$message = $this->getMessage('messages.tsc_required');
			Toast::message($message, 'danger');
		}
		else{
			$item = \App\TestScenario::find($request->tsc_id);
			$new_tsc_id		= $item->tsc_id =$request->tf_id."_". $this->genrateRandomInt();
			$item->tf_id 	= $request->tf_id;				
			$item->tp_id 	= session()->get('open_project');
			$item->status 	= 'not_executed';
			\App\TestScenario::create($item->toArray());
			
			if($request->all_testcases == true){
				$clone_obj = new CloneHandler();
				$clone_obj->cloneAllCases($request->tsc_id , $item->tsc_id, true);
			}
			$message = $this->getMessage('messages.clone_success');
			Toast::message($message, 'success');
			return redirect()->route('scenario.show', ['id' => $new_tsc_id]);
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
				$content['tsc_id']                 	= $request->tf_id."_".$this->genrateRandomInt(4);		
				$content['tsc_name']                = $request->name;
				$content['scenario_brief']          = "";
				$content['description']             = $request->description;
		        $content['expected_result']         = $request->expected_result;		
		        $content['status'] 					= "not_executed";

		       	$count 								= \App\TestScenario::where('tf_id',  $content['tf_id'])->count();
		       	$content['seq_no'] 	        		= $count+1;
		       	$content['actual_result'] 	  		= "not_executed";

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

		$case_details = \App\TestCase::where('tsc_id' , $id)->orderBy('seq_no', 'asc')->get();
		//$cases = \App\TestCase::where('tsc_id' , $id)->get()->toArray();
		$scenario->cases = count($case_details);

		$f_cases = array();
		foreach ($case_details as $key => $value) {
			$f_cases[] = $value['tc_id'];
		}

		$scenario->steps = \App\TestCase::join('teststeps', 
								'testcases.tc_id', '=', 'teststeps.tc_id')
								->whereIn('testcases.tc_id', $f_cases)
								->count();

		$clone = \App\TestCase::all();
		return view('show.scenario', ['scenario' => $scenario, 'case_details'=> $case_details, 'clone_case' => $clone]);
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
			'name' => 'required' 
			//'status' => 'required'        
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
		        $scenario_update 					= \App\TestScenario::find($id);
		        $old_description 					= $scenario_update->description;

		        $scenario_update->update($content);

		        if($request->update_level == "project"){
		        	$tp_id = session()->get('open_project');
		        	unset($content['tsc_name']);
		        	\App\TestScenario::where(['description' => $old_description, 'tp_id' => $tp_id])->update($content);
		        }
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
	        	//Delete testlabs and execution steps
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
        }
		else{
			$message = $this->getMessage('messages.delete_failed');
			Toast::message($message, 'danger');
		}
		return redirect()->route('functionality.show', $tf_id);
	}

}
