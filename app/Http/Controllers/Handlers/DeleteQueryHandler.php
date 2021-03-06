<?php namespace App\Http\Controllers\Handlers;

class DeleteQueryHandler {

	/**
	 * Delete scenarios query by functionality id
	 *
	 * @return int
	 */

	public function deleteFunctionalityByProjectId($id)
	{    
		try{  
			//Start deleting from lowest child
        	$functionality = \App\TestFunctionality::where('tp_id' , $id)->get()->toArray();        	
        	foreach ($functionality as $f_value) {
        		$tf_id = $f_value['tf_id'];
    		   	$this->deleteScenarioByFunctionalityId($tf_id);
        	}

        	//Delete associated teststeps       	
        	$tf = \App\TestFunctionality::where('tp_id' , $id)->delete();		
		}catch(Exception $e)
		{
			return 0;
		}
		return 1;
	}

	/**
	 * Delete scenarios query by functionality id
	 *
	 * @return int
	 */

	public function deleteScenarioByFunctionalityId($id)
	{    
		try{  
			//Start deleting from lowest child
        	$scs = \App\TestScenario::where('tf_id' , $id)->get()->toArray();        	
        	foreach ($scs as $sc_value) {
        		$tsc_id = $sc_value['tsc_id'];
    		   	$this->deleteCaseByScenarioId($tsc_id);
    		   	$this->deleteScLabByScenarioId($tsc_id);

        	}

        	//Delete associated teststeps        	     	
        	$scs = \App\TestScenario::where('tf_id' , $id)->delete();

		}catch(Exception $e)
		{
			return 0;
		}
		return 1;
	}

	/**
	 * Delete testcases query by scenario id
	 *
	 * @return int
	 */

	public function deleteCaseByScenarioId($id)
	{    
		try{  
			//Start deleting from lowest child
        	$cases = \App\TestCase::where('tsc_id' , $id)->get()->toArray();        	
        	foreach ($cases as $c_value) {
        		$tc_id = $c_value['tc_id'];
    		   	$this->deleteStepsByCaseId($tc_id);
    		   	$this->deleteLabByCaseId($tc_id);
        	}

        	//Delete associated testcases      	
        	$case = \App\TestCase::where('tsc_id' , $id)->delete();	


		}catch(Exception $e)
		{
			return 0;
		}
		return 1;
	}

	/**
	 * Delete Scenarion Labs query by testcase id
	 *
	 * @return int
	 */

	public function deleteScLabByScenarioId($id)
	{  
		$tp_id = session()->get('open_project');  
		try{  
			$deletedRows = \App\ScenarioLab::where(['tsc_id' => $id , 'tp_id' => $tp_id])->delete();
		}catch(Exception $e)
		{
			return 0;
		}
		return 1;
	}

	/**
	 * Delete Labs query by testcase id
	 *
	 * @return int
	 */

	public function deleteLabByCaseId($id)
	{  
		$tp_id = session()->get('open_project');  
		try{  
			$deletedRows = \App\Lab::where(['tc_id' => $id , 'tp_id' => $tp_id])->delete();
		}catch(Exception $e)
		{
			return 0;
		}
		return 1;
	}

	/**
	 * Soft Delete Steps query by testcase id
	 *
	 * @return int
	 */
	public function softDeleteStepsByCaseId($id)
	{    
		try{  
			//Update show as false
        	//$steps = \App\TestStep::where('tc_id' , $id)->get()->toArray();        	
        	$steps = \App\TestStep::where('tc_id' , $id)->update(['soft_delete'=> true]);	
		}catch(Exception $e)
		{
			return 0;
		}
		return 1;
	}



	/**
	 * Delete Steps query by testcase id
	 *
	 * @return int
	 */

	public function deleteStepsByCaseId($id)
	{    
		try{  
			//Start deleting from lowest child (execution)
        	$steps = \App\TestStep::where('tc_id' , $id)->get()->toArray();        	
        	foreach ($steps as $s_value) {
        		$ts_id = $s_value['ts_id'];
    		   	$this->deleteExecutionByStepId($ts_id);
        	}
        	//Delete associated teststeps       	
        	$steps = \App\TestStep::where('tc_id' , $id)->delete();		
		}catch(Exception $e)
		{
			return 0;
		}
		return 1;
	}

	/**
	 * Delete Steps query by testcase id
	 *
	 * @return int
	 */

	public function deleteExecutionByStepId($id)
	{  
		$tp_id = session()->get('open_project');  
		try{  
			$e_deletedRows = \App\Execution::where(['ts_id' => $id , 'tp_id' => $tp_id])->delete();
		}catch(Exception $e)
		{
			return 0;
		}
		return 1;
	}

	/**
	 * Delete Labs query by testcase id
	 *
	 * @return int
	 */

	public function deleteLabByScLabId($id)
	{    
		try{  
			$case_labs = \App\Lab::where('scl_id' , $id)->get()->toArray();        	
        	foreach ($case_labs as $c_value) {
        		$this->deleteExecutionByTestLabId($c_value['tl_id']);
        	}
			$deletedRows = \App\Lab::where(['scl_id' => $id])->delete();
		}catch(Exception $e)
		{
			return 0;
		}
		return 1;
	}
	/**
	 * Delete Execution steps query by tl_id
	 *
	 * @return int
	 */

	public function deleteExecutionByTestLabId($id)
	{  
		try{  
			$e_deletedRows = \App\Execution::where(['tl_id' => $id])->delete();
		}catch(Exception $e)
		{
			return 0;
		}
		return 1;
	}

	public function getCondition($item, $level )
	{
		$condition['expected_result'] = $item->expected_result;
		$condition['description'] 	  = $item->description;
	
		switch ($level) {
			case 'step':
			 	$condition['ts_id'] = $item->ts_id;
				break;

			case 'case':
			 	$condition['tc_id'] = $item->tc_id;
				break;

			case 'scenario':
				$case =\App\TestCase::find($item->tc_id);
				$condition['tsc_id'] = $case->tsc_id;
				break;

			case 'functionality':
				$case =\App\TestCase::find($item->tc_id);
				$condition['tf_id'] = $case->tf_id;
				break;

			case 'project':
				$condition['tp_id'] = $item->tp_id;
				break;
		}
		return $condition;
	}
}