<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

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
			'prefix' => 'required',
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
				$content['tp_id']                 	= $request->prefix.$this->genrateRandomInt();				
				$content['tp_name']                 = $request->name;
				$content['release']                 = $request->release;				
		        $content['created_by'] 				= session()->get('email');
		        $content['description']             = $request->description;
		        $create 							= \App\TestProject::create($content);
		        //return redirect()->route('profile', ['message' => ""]);
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
		/*if($id == "{project}")
			$id = session()->get('open_project');
*/
		$project = \App\TestProject::find($id);
		$project->functionalities = \App\TestFunctionality::where('tp_id' , $id)->count();
		$project->scenarios = \App\TestScenario::where('tp_id' , $id)->count();
		$project->cases = \App\TestCase::where('tp_id' , $id)->count();
		$project->steps = \App\TestStep::where('tp_id' , $id)->count();		
		return view('show.project', ['project' => $project]);	  	
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
		        //$content['description']             = $request->description;
		        \App\TestProject::find($id)->update($content);
		        //$create 							= \App\TestProject::create($content);
		        //return redirect()->route('profile', ['message' => ""]);
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
		//
	}

}
