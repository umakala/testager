<?php namespace App\Http\Controllers\Handlers;

class StoreQueryHandler {

	/**
	 * add scenarios query by functionality id
	 *
	 * @return int
	 */

	public function addFunctionalityByProjectId($id)
	{    
		try{  
			//Start deleting from lowest child
        	$functionality = \App\TestFunctionality::where('tp_id' , $id)->get()->toArray();        	
        	foreach ($functionality as $f_value) {
        		$tf_id = $f_value['tf_id'];
    		   	$this->addScenarioByFunctionalityId($tf_id);
        	}

        	//add associated teststeps       	
        	$tf = \App\TestFunctionality::where('tp_id' , $id)->add();		
		}catch(Exception $e)
		{
			return 0;
		}
		return 1;
	}

	/**
	 * add scenarios query by functionality id
	 *
	 * @return int
	 */

	public function addScenarioByFunctionalityId($id)
	{    
		try{  
			//Start deleting from lowest child
        	$scs = \App\TestScenario::where('tf_id' , $id)->get()->toArray();        	
        	foreach ($scs as $sc_value) {
        		$tsc_id = $sc_value['tsc_id'];
    		   	$this->addCaseByScenarioId($tsc_id);
    		   	$this->addScLabByScenarioId($tsc_id);

        	}

        	//add associated teststeps        	     	
        	$scs = \App\TestScenario::where('tf_id' , $id)->add();

		}catch(Exception $e)
		{
			return 0;
		}
		return 1;
	}

	/**
	 * add testcases query by scenario id
	 *
	 * @return int
	 */

	public function addCaseByScenarioId($id)
	{    
		try{  
			//Start deleting from lowest child
        	$cases = \App\TestCase::where('tsc_id' , $id)->get()->toArray();        	
        	foreach ($cases as $c_value) {
        		$tc_id = $c_value['tc_id'];
    		   	$this->addStepsByCaseId($tc_id);
    		   	$this->addLabByCaseId($tc_id);
        	}

        	//add associated testcases      	
        	$case = \App\TestCase::where('tsc_id' , $id)->add();	


		}catch(Exception $e)
		{
			return 0;
		}
		return 1;
	}

	/**
	 * add Steps query by testcase id
	 *
	 * @return int
	 */

	public function addStep($ts_id, $request, $e_id, $tc)
	{  
		try{  
				$content['ts_id']                 	= $ts_id;
				$content['ts_name']                 = "";
				$content['created_by'] 				= session()->get('email');
		        $content['description']             = $request->description;
		        $content['expected_result']         = $request->expected_result;
				$content['status']             		= "not_executed";
		        $content['tp_id']                 	= session()->get('open_project');
		        $content['tc_id']                 	= $tc;
		        $content['seq_no'] 	        		= $request->seq_no;	
		        if($content['seq_no']  == null ||  $content['seq_no']  == "" )
		        {
		        	$count 								= \App\TestStep::where('tc_id', $tc)->count();
		       		$content['seq_no'] 	        		= $count+1;	
		       	}	
		        $create 							= \App\TestStep::create($content);

		        //Add entry in execution table for this step
				if($this->addExecution($e_id, $request, $content) == 0)
					return 0;
		}catch(Exception $e)
		{
			return 0;
		}
		return 1;
	}

	/**
	 * add Execution steps query
	 *
	 * @return int
	 */

	public function addExecution($e_id, $request, $content)
	{  
		try{  
			$execution_content['scroll']		= $request->scroll;
	        $execution_content['resource_id']	= $request->resource_id;
	        $execution_content['text']			= $request->text;
	        $execution_content['content_desc']	= $request->content_desc;
	        $execution_content['class']			= $request->class;
	        $execution_content['index']			= $request->index;
	        $execution_content['sendkey']		= $request->sendkeys;
	        $execution_content['screenshot']	= $request->screenshot;
	        $execution_content['checkpoint']	= $request->checkpoint;
	        $execution_content['wait']			= $request->wait;
	        $execution_content['tc_id']			= $request->tc_id;
	        $execution_content['tp_id']			= $content['tp_id'];
	        $execution_content['ts_id']			= $content['ts_id'];
	        $execution_content['tl_id']			= 0;
	        $execution_content['seq_no']		= $content['seq_no'];

	        $execution_content['e_id']			= $e_id;
	        $create 							= \App\Execution::create($execution_content);
		}catch(Exception $e)
		{
			return 0;
		}
		return 1;
	}

	public function getAddCondition($level, $tc_id)
	{
		$testcase = \App\TestCase::find($tc_id);
		$condition['expected_result'] = $testcase->expected_result;

		switch ($level) {
			case 'case':
			 	$condition['tc_id'] = $tc_id;
				break;

			case 'scenario':
				$condition['tsc_id'] = $testcase->tsc_id;
				break;

			case 'functionality':
				$condition['tf_id'] = $testcase->tf_id;
				break;

			case 'project':
				$condition['tp_id'] = session()->get('open_project');
				break;
		}
		return $condition;
	}
}