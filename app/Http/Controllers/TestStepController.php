<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Handlers\DeleteQueryHandler;
use App\Http\Controllers\Handlers\StoreQueryHandler;

use Illuminate\Http\Request;
use Toast;


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
			if(session()->has('email')){

				$store_obj = new StoreQueryHandler();
				$level =  $request->add_level;
				//Process when validations pass
				/*$ts_id                	= $tc."_". $this->genrateRandomInt();
				$e_id 					= $ts_id."_".$this->genrateRandomInt();
				$store_obj->addStep($ts_id, $request, $e_id, $tc);
				*/
				$condition = $store_obj->getAddCondition($level, $tc);
				$all_cases = \App\TestCase::where($condition)->get();

				foreach ($all_cases as $case_value) {
						$ts_id                	= $case_value->tc_id."_". $this->genrateRandomInt();
						$e_id 					= $ts_id."_".$this->genrateRandomInt();
						$store_obj->addStep($ts_id, $request, $e_id, $case_value->tc_id);
				}
			 	
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

				$level = $request->update_level; 	
				$content['description']             = $request->description;
		        $content['expected_result']         = $request->expected_result;
		        $item = \App\TestStep::find($id);
		        $item->update($content);
		        
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
				$tc_id								= $request->tc_id;

		        $result = \App\Execution::where(['ts_id' => $id, 'tl_id' => 0])->update($execution_content);

				$del_obj = new DeleteQueryHandler();				
	        	$condition = $del_obj->getCondition($item, $level);
	        	$condition['soft_delete'] = false;

	        	$all_steps = \App\TestStep::where($condition)->get();
	        	foreach ($all_steps as $step_value) {
	        		if($step_value->ts_id != $id)
	        		{
	        			$step_value->update($content);

	        			//exit;
	        			\App\Execution::where(['ts_id' => $step_value->ts_id, 'tl_id' => 0])->update($execution_content);
	        		}
	        	}

				return redirect()->route('testcase.show', ['id' => $tc_id]);

			 	//return redirect()->route('teststep.show', ['id' => $id]);
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
	public function destroy($id, Request $request)
	{
		//echo "Deleting this Step";
		$level = ($request->delete_level);
		$tp_id = session()->get('open_project');
		$item = \App\TestStep::find($id);
		//$expected_result = $item->expected_result;
		
        if($item){
        	$tc_id = $item->tc_id;
        	$del_obj = new DeleteQueryHandler();
        	$condition = $del_obj->getCondition($item, $level);
        	$all_steps = \App\TestStep::where($condition)->get();
        	foreach ($all_steps as $step_value) {
        		if($step_value->ts_id != $id)
        		{
        			$del_res = $del_obj->deleteExecutionByStepId($step_value->ts_id);
        			$step_value->delete();
        		}
        	}

        	$del_res = $del_obj->deleteExecutionByStepId($id);
			if($del_res == 0)
			{
				$message = $this->getMessage('messages.delete_failed');
				Toast::message($message, 'danger');
			}  else{      	
	        	//Delete teststep
	        	$item->delete();
				$message = $this->getMessage('messages.delete_success');
				Toast::success($message);
			}
        }
		else{
			$message = $this->getMessage('messages.delete_failed');
			Toast::message($message, 'danger');
			return back();
		}

		return redirect()->route('testcase.show', ['id' => $tc_id ]);
	}

	/**
	 * commits reorder changes to db.
	 *
	 * @return Response
	 */
	public function reorder(Request $request)
	{
		$order_values = $request->all();
		//print_r($order_values);
		if(count($order_values) === count(array_unique($order_values)))
		{
			foreach ($request->all() as $key => $value) {
				//echo " key = $key and value = $value";
				\App\TestStep::find($key)->update(['seq_no'=> $value]);
				\App\Execution::where('ts_id', $key)->update(['seq_no' => $value]);
			}
			$message = $this->getMessage('messages.reorder_success');
			Toast::message($message, 'success');
		}else{
			$message = $this->getMessage('messages.reorder_duplication');
			Toast::message($message, 'danger');
		}	
		return redirect()->back();
	}

}
