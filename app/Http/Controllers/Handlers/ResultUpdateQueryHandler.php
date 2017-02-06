<?php namespace App\Http\Controllers\Handlers;

class ResultUpdateQueryHandler {

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
	 * Update Labs query by scenario lab id
	 *
	 * @return int
	 */

	public function updateLabsByScenarioLabId($id, $set)
	{  
		$tp_id = session()->get('open_project');  
		try{  

			$condition = ['scl_id' => $id , 'tp_id' => $tp_id];

			//Start updating from lowest child
        	$labs = \App\Lab::where($condition)->get()->toArray();        	
        	foreach ($labs as $l_value) {
        		$tl_id = $l_value['tl_id'];
    		   	$this->updateExecutionByLabId($tl_id, $set);
        	}

        	//Update associated labs      	
			\App\Lab::where($condition)->update($set);
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

	public function updateExecutionByLabId($id, $set)
	{  
		$tp_id = session()->get('open_project'); 

		unset($set['executed_by']);
		unset($set['execution_type']); 

		try{  
			\App\Execution::where(['tl_id' => $id , 'tp_id' => $tp_id])->update($set);
		}catch(Exception $e)
		{
			return 0;
		}
		return 1;
	}

}
