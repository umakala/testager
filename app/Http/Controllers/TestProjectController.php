<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Handlers\DeleteQueryHandler;

use Illuminate\Http\Request;
use Toast;

class TestProjectController extends Controller {

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
		return view('forms.project');	
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
			'release' => 'required',
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
				$id = $content['tp_id']            	= $this->genrateRandomInt();
				$content['tp_name']                 = $request->name;
				$content['release']                 = $request->release;	
				$content['package_name']            = $request->package_name;
				$content['activity_name']           = $request->activity_name;							
		        $content['created_by'] 				= session()->get('email');
		        $content['description']             = $request->description;
		        $create 							= \App\TestProject::create($content);
		        $user = \App\User::where('email',session()->get('email'))->update(['open_project' => $id]);
				session(['open_project' => $id]);
		        return redirect()->route('profile');
		 	}else
		 	{
		 		$error[] = "Session expired. Please login to continue";
		 	}
	 	}
	 	return redirect()->route('project.create', ['message' => $error])->withInput();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		if($id == "{project}" || !isset($id))
			$id = session()->get('open_project');



		$project = \App\TestProject::find($id);
		$functionalities = \App\TestFunctionality::where('tp_id' , $id)->get();

		$project->functionalities = count($functionalities);
		$project->scenarios = \App\TestScenario::where('tp_id' , $id)->count();
		$project->cases = \App\TestCase::where('tp_id' , $id)->count();
		$project->steps = \App\TestStep::where('tp_id' , $id)->count();	
		foreach ($functionalities as $key => $value) {
			$value->scenarios = \App\TestScenario::where('tf_id' , $value->tf_id)->count();
		}

		$fn = \App\TestFunctionality::all();
		$all_projects = \App\TestProject::all();
		$view = ['project' => $project, 'functionalities' => $functionalities, 'clone_fn' => $fn, 'all_projects' => $all_projects ];

		return view('show.project', $view );	  	
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$project = \App\TestProject::find($id);
		return view('forms.edit_project', ['project' => $project]);	
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
				$content['tp_name']                 = $request->name;
				$content['release']                 = $request->release;
				$content['package_name']            = $request->package_name;
				$content['activity_name']           = $request->activity_name;
				//$content['app_wait_activity']       = $request->app_wait_activity;
		        \App\TestProject::find($id)->update($content);
		        return redirect()->route('project.show', ['id' => $id]);
		 	}else
		 	{
		 		$error[] = "Session expired. Please login to continue";
		 	}
	 	}
	 	return redirect()->route('project.edit', ['id' => $id, 'message' => $error])->withInput();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$item = \App\TestProject::find($id);
		if($item){
        	$del_obj = new DeleteQueryHandler();
        	$del_res = $del_obj->deleteFunctionalityByProjectId($id);
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
		return redirect()->route('profile');
	}

}
