<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Handlers\DeleteQueryHandler;
use App\Http\Controllers\Handlers\CloneHandler;
use DB;
use Toast;

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

	public function cloneFunctionality(Request $request)
	{
		//echo 'cloning for '.$request->tsc_id;
		if($request->tf_id == "none")
		{
			$message = $this->getMessage('messages.tf_required');
			Toast::message($message, 'danger');
		}
		else{
			$item = \App\TestFunctionality::find($request->tf_id);
			$new_fn_id 		= $item->tf_id 	= $this->genrateRandomInt();
			$item->tp_id 	= session()->get('open_project');
			$item->status 	= 'not_executed';
			$item->created_by 	= session()->get('email');

			\App\TestFunctionality::create($item->toArray());
			
			if($request->all_scenarios == true){
				$clone_obj = new CloneHandler();
				$clone_obj->cloneAllScenarios($request->tf_id , $item->tf_id, true);
			}
			$message = $this->getMessage('messages.clone_success');
			Toast::message($message, 'success');
			return redirect()->route('functionality.show', ['id' => $new_fn_id]);
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
		return view('forms.functionality');
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
				$content['created_by']            	= session()->get('email');
				
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

		$clone_sc = \App\TestScenario::all();

		$scenarios = \App\TestScenario::where('tf_id' , $id)->orderBy('seq_no', 'asc')->get();
		$functionality->scenarios = count($scenarios);

		foreach ($scenarios as $sc_value) {
			$sc_value->testcases = \App\TestCase::where('tsc_id' , $sc_value->tsc_id)->count();
		}


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

		return view('show.functionality', ['functionality' => $functionality, 'scenarios' => $scenarios , 'clone_sc' => $clone_sc]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$functionality = \App\TestFunctionality::find($id);
		return view('forms.edit_functionality', ['functionality' => $functionality]);
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
				$content['tf_name']                 = $request->name;
				$content['description']             = $request->description;
		        \App\TestFunctionality::find($id)->update($content);
		        //return redirect()->route('profile', ['message' => ""]);
			 	return redirect()->route('functionality.show', ['id' => $id]);
		 	}else
		 	{
		 		$error[] = "Session expired. Please login to continue";
		 	}
	 	}
	 	return redirect()->route('functionality.edit', ['id' => $id, 'message' => $error])->withInput();
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
		$item = \App\TestFunctionality::find($id);
		if($item){
        	$del_obj = new DeleteQueryHandler();
        	$del_res = $del_obj->deleteScenarioByFunctionalityId($id);
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
		return redirect()->route('project.show', $tp_id);
	}

}
