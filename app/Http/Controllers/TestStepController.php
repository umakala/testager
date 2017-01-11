<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class TestStepController extends Controller {

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
	public function create($tc_id)
	{	
		if($tc_id != null)
			$cases = \App\TestCase::where('tc_id' , $tc_id)->get();
		else		
			$cases = \App\TestCase::where('tp_id' , session()->get('open_project'))->get();
		return view('forms.teststep', ['cases' =>$cases]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store( Request $request)
	{

		$messages = [
		    'tc_id.not_in' => 'The case field is required.'
		];

	 	$tc =  $request->tc_id;
		$validator = \Validator::make($request->all(), array(
			'description' => 'required',
			'tc_id' => 'not_in:none'        
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
				$content['ts_id']                 	= $this->genrateRandomInt();				
				$content['ts_name']                 = "";
				$content['created_by'] 				= session()->get('email');
		        $content['description']             = $request->description;
		        $content['expected_result']         = $request->expected_result;
				$content['status']             		= "not_executed";
		        $content['tp_id']                 	= session()->get('open_project');
		        $content['tc_id']                 	= $tc;				
		        $create 							= \App\TestStep::create($content);

		        //Add entry in execution table for this step
		        $execution_content['scroll']		= $request->scroll;
		        $execution_content['resource_id']	= $request->resource_id;
		        $execution_content['text']			= $request->text;
		        $execution_content['content_desc']	= $request->content_desc;
		        $execution_content['class']			= $request->class;
		        $execution_content['index']			= $request->index;
		        $execution_content['sendkey']		= $request->sendkey;
		        $execution_content['screenshot']	= $request->screenshot;
		        $execution_content['checkpoint']	= $request->checkpoint;
		        $execution_content['wait']			= $request->wait;
		        $execution_content['tc_id']			= $tc;
		        $execution_content['tp_id']			= $content['tp_id'];
		        $execution_content['ts_id']			= $content['ts_id'];
		        $execution_content['e_id']			= $this->genrateRandomInt();

		        $create 							= \App\Execution::create($execution_content);

		        //return redirect()->route('profile', ['message' => ""]);
			 	return redirect()->route('testcase.show', ['id' => $tc] );
		 	}else
		 	{
		 		$error[] = "Session expired. Please login to continue";
		 	}
	 	}

	 	return redirect()->route('teststep.create', [ 'tc_id' => $tc, 'message' => $error ])->withInput();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$step = \App\TestStep::find($id);
		$execution = \App\Execution::where('ts_id', $id)->first(); 	

		return view('show.step', ['step' => $step, 'execution' => $execution]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$step = \App\TestStep::find($id);
		$step->tc_name = \App\TestCase::select('tc_name')->where('tc_id', $step->tc_id)->get()[0]['tc_name'];
		//return $step;

		$execution = \App\Execution::where('ts_id', $id)->first(); 

		if($execution == null)
			 $execution = (object) array();
		
		return view('forms.edit_teststep', ['step' => $step , 'execution' => $execution]);
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
			'description' => 'required',
			'expected_result' => 'required'    
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

				$content['description']             = $request->description;
		        $content['expected_result']         = $request->expected_result;
		        \App\TestStep::find($id)->update($content);


		        $execution_content['scroll']		= $request->scroll;
		        $execution_content['resource_id']	= $request->resource_id;
		        $execution_content['text']			= $request->text;
		        $execution_content['content_desc']	= $request->content_desc;
		        $execution_content['class']			= $request->class;
		        $execution_content['index']			= $request->index;
		        $execution_content['sendkey']		= $request->sendkey;
		        $execution_content['screenshot']	= $request->screenshot;
		        $execution_content['checkpoint']	= $request->checkpoint;
		        $execution_content['wait']			= $request->wait;		        

		        $result = \App\Execution::where('ts_id', $id)->update($execution_content);

			 	return redirect()->route('teststep.show', ['id' => $id]);
		 	}else
		 	{
		 		$error[] = "Session expired. Please login to continue";
		 	}
	 	}
	 	return redirect()->route('teststep.edit', ['id' => $id, 'message' => $error])->withInput();
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
