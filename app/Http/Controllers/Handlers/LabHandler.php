<?php namespace App\Http\Controllers\Handlers;


use App\Http\Controllers\Controller;

class LabHandler extends Controller{

	/**
	 * Create scenario lab by scenario obj
	 *
	 * @return int
	 */

	public function createScLabByScenarioDetails($sc)
	{ 
		$final_data = [];
		//Start by creating lab for highest level of hierarchy 
		$tp_id 				= session()->get('open_project');  
		$scl_id 			= $sc_lab['scl_id'] 	= $this->genrateRandomInt();
		$sc_lab['tp_id'] 	= session()->get('open_project');
		$sc_lab['tsc_id'] 	= $sc->tsc_id;
		$sc_lab['tf_id'] 	= $sc->tf_id;
		$sc_lab['result'] 	= '';
		$sc_lab['execution_type'] 	= '';
		$sc_lab['executed_by'] 		= '';
		\App\ScenarioLab::create($sc_lab);


		/*
		$excel_data['Scenario ID']   = $sc_lab['scl_id'];
		$excel_data['Scenario Name'] = $sc->tsc_name;
		$excel_data['Scenario Description'] = $sc->description;
		$excel_data['Scenario Result']   = '';

    	$cases = \App\TestCase::where('tsc_id' , $sc->tsc_id)->orderBy('seq_no', 'asc')->get()->toArray();

    	$case_count = 0;
    	foreach ($cases as $c_value) {
    		//echo $c_value['tc_name'];
    		$tc_id = $c_value['tc_id'];
    		if($case_count != 0){
		   		$excel_data['Scenario ID']   = '';
				$excel_data['Scenario Name'] = '';
				$excel_data['Scenario Description'] = '';				
				$excel_data['Scenario Result']   = '';
		   	}
		   	$case_count++;
		   	$excel_data = $this->createLabByCase($c_value, $sc->tf_id, $sc_lab['scl_id'], $excel_data);
		   	$tl_id = $excel_data['Test Case ID'];
		   	
		   	$steps 						= \App\TestStep::where(['tc_id'=> $tc_id])->orderBy('seq_no', 'asc')->get();

			$step_count = 0;
			foreach ($steps as $ts_value) {
	        		if($step_count != 0){
	        			$excel_data['Scenario ID']   = '';
						$excel_data['Scenario Name'] = '';
						$excel_data['Scenario Result']   = '';
						$excel_data['Scenario Description'] = '';				
	        			$excel_data['Test Case ID'] = '';
	    		   		$excel_data['Test Case Name'] = '';
	    		   		$excel_data['Test Case Description'] = '';
	    		   		$excel_data['Case Result'] = '';
	    		   	}
	    		   	$excel_data = $this->createExecutionByStep($ts_value, $tl_id, $excel_data);
	    		    $final_data[] = $excel_data; 
	    		   	$step_count++;
	        }
		}*/
		return $scl_id;
	}

	public function getScLabByScenarioLabId($scl_id)
	{ 
		$final_data = [];
		//Start by getting lab for highest level of hierarchy 
		$tp_id 				= session()->get('open_project');  
		/*$sc_lab['scl_id'] 	= $this->genrateRandomInt();
		$sc_lab['tp_id'] 	= session()->get('open_project');
		$sc_lab['tsc_id'] 	= $sc->tsc_id;
		$sc_lab['tf_id'] 	= $sc->tf_id;
		$sc_lab['result'] 	= '';
		$sc_lab['execution_type'] 	= '';
		$sc_lab['executed_by'] 		= '';
		\App\ScenarioLab::create($sc_lab);
		*/
		$sc_lab = \App\ScenarioLab::find($scl_id)->toArray();
		$sc 	= \App\TestScenario::find($sc_lab['tsc_id']);

		$excel_data['Scenario ID']   = $sc_lab['scl_id'];
		$excel_data['Scenario Name'] = $sc->tsc_name;
		$excel_data['Scenario Description'] = $sc->description;
		$excel_data['Scenario Result']   = '';

		$tf_id = $sc_lab['tf_id'];

    	$cases = \App\Lab::where('scl_id' , $scl_id)->orderBy('seq_no', 'asc')->get()->toArray();

    	$case_count = 0;
    	foreach ($cases as $c_value) {
    		//echo $c_value['tc_name'];
    		$tc_id = $c_value['tc_id'];
    		if($case_count != 0){
		   		$excel_data['Scenario ID']   = '';
				$excel_data['Scenario Name'] = '';
				$excel_data['Scenario Description'] = '';				
				$excel_data['Scenario Result']   = '';
		   	}
		   	$case_count++;
			/*
		   	$excel_data = $this->getLabByLabId($c_value['tl_id'], $tf_id, $sc_lab['scl_id'], $excel_data);*/
		   	$case = \App\TestCase::find($c_value['tc_id'])->toArray();
		   	$excel_data['Test Case ID'] =  $c_value['tl_id'];
	   		$excel_data['Test Case Name'] = $case['tc_name'];
		    $excel_data['Test Case Description'] = $case['description'];
	   		$excel_data['Case Result'] = '';
		   	$tl_id = $c_value['tl_id'];
		   	
		   	$executions		= \App\Execution::where('tl_id', $tl_id)->orderBy('seq_no', 'asc')->get();
			$step_count = 0;
			foreach ($executions as $ts_value) {
	        		if($step_count != 0){
	        			$excel_data['Scenario ID']   = '';
						$excel_data['Scenario Name'] = '';
						$excel_data['Scenario Result']   = '';
						$excel_data['Scenario Description'] = '';				
	        			$excel_data['Test Case ID'] = '';
	    		   		$excel_data['Test Case Name'] = '';
	    		   		$excel_data['Test Case Description'] = '';
	    		   		$excel_data['Case Result'] = '';
	    		   	}
	    		   	$step = \App\TestStep::find($ts_value['ts_id']);
	    		   	$excel_data['Test Step ID']					= $ts_value['e_id'];
					$excel_data['Test Step Description']		= $step->description;
					$excel_data['Step Result'] 					= '';

	    		   //$excel_data = $this->createExecutionByStep($ts_value, $tl_id, $excel_data);
	    		    $final_data[] = $excel_data; 
	    		   	$step_count++;
	        }
		}
		return $final_data;
	}

	public function getExecutionByStep($step, $tl_id, $execution_data)
	{ 
		$execution 				=  \App\Execution::where(['tc_id' => $step->tc_id, 'ts_id' => $step->ts_id])->get()->toArray();
		if(count ($execution) != 0)
		{
			$exe_data 						= $execution[0];
			$exe_data['e_id']				= $tl_id."_".$this->genrateRandomInt(8);
			$exe_data['tl_id']				= $tl_id;
			$exe_data['execution_result'] 	= '';
			$exe_data['checkpoint_result'] 	= '';
			$exe_data['executed_by'] 		= session()->get('email');
			$exe_data['executed_by_name'] 	= session()->get('name');
			unset($exe_data['created_at']);
			unset($exe_data['updated_at']);
			$created_exe 					= \App\Execution::create($exe_data);
			
		}
		return $execution_data;
	}


	public function createScLabByScenario($sc)
	{ 
		$final_data = [];
		//Start by creating lab for highest level of hierarchy 
		$tp_id 				= session()->get('open_project');  
		$sc_lab['scl_id'] 	= $this->genrateRandomInt();
		$sc_lab['tp_id'] 	= session()->get('open_project');
		$sc_lab['tsc_id'] 	= $sc->tsc_id;
		$sc_lab['tf_id'] 	= $sc->tf_id;
		$sc_lab['result'] 	= '';
		$sc_lab['execution_type'] 	= '';
		$sc_lab['executed_by'] 		= '';
		\App\ScenarioLab::create($sc_lab);

		$excel_data['Scenario ID']   = $sc_lab['scl_id'];
		$excel_data['Scenario Name'] = $sc->tsc_name;
		$excel_data['Scenario Description'] = $sc->description;
		$excel_data['Scenario Result']   = '';

    	$cases = \App\TestCase::where('tsc_id' , $sc->tsc_id)->orderBy('seq_no', 'asc')->get()->toArray();

    	$case_count = 0;
    	foreach ($cases as $c_value) {
    		//echo $c_value['tc_name'];
    		$tc_id = $c_value['tc_id'];
    		if($case_count != 0){
		   		$excel_data['Scenario ID']   = '';
				$excel_data['Scenario Name'] = '';
				$excel_data['Scenario Description'] = '';				
				$excel_data['Scenario Result']   = '';
		   	}
		   	$case_count++;
		   	$excel_data = $this->createLabByCase($c_value, $sc->tf_id, $sc_lab['scl_id'], $excel_data);
		   	$tl_id = $excel_data['Test Case ID'];
		   	
		   	$steps 						= \App\TestStep::where(['tc_id'=> $tc_id])->orderBy('seq_no', 'asc')->get();

			$step_count = 0;
			foreach ($steps as $ts_value) {
	        		if($step_count != 0){
	        			$excel_data['Scenario ID']   = '';
						$excel_data['Scenario Name'] = '';
						$excel_data['Scenario Result']   = '';
						$excel_data['Scenario Description'] = '';				
	        			$excel_data['Test Case ID'] = '';
	    		   		$excel_data['Test Case Name'] = '';
	    		   		$excel_data['Test Case Description'] = '';
	    		   		$excel_data['Case Result'] = '';
	    		   	}
	    		   	$excel_data = $this->createExecutionByStep($ts_value, $tl_id, $excel_data);
	    		    $final_data[] = $excel_data; 
	    		   	$step_count++;
	        }
		}
		return $final_data;
	}

	/**
	 * Delete Labs query by testcase id
	 *
	 * @return int
	 */

	public function createLabByCase($case, $tf_id, $scl_id, $excel_data)
	{  
		$tp_id = session()->get('open_project');  

		//Create a test lab for each test case execution
		$lab['tl_id'] 				= $scl_id."_".$this->genrateRandomInt();  		 
		$lab['tp_id'] 				= $tp_id;	  		
		$lab['tc_id'] 				= $case['tc_id'];
		$lab['scl_id'] 				= $scl_id;		
		$lab['tf_id'] 				= $tf_id;
		$lab['tsc_id']				= $case['tsc_id'];	  		
		$lab['bug_id'] 				= '';
		$lab['tc_status'] 			= '';
		$lab['execution_type'] 		= '';
		$lab['executed_by'] 		= session()->get('email');
		$lab['executed_by_name']	= session()->get('name'); 
		$lab['executed_result'] 	= '';
		$lab['checkpoint_result'] 	= '';
		$lab['seq_no']				= $case['seq_no'];
		$lab['executed_filename'] 	= ''; //.".xls";
		$lab['release_version']		= $excel_data['release_version'];
		$lab['os_version']			= $excel_data['os_version'];
		$lab['network_type']		= $excel_data['network_type'];
		$lab['device_name']			= $excel_data['device_name'];
		$c_lab 						=\App\Lab::create($lab);
		$excel_data['Test Case ID'] =  $lab['tl_id'];
   		$excel_data['Test Case Name'] = $case['tc_name'];
	    $excel_data['Test Case Description'] = $case['description'];
   		$excel_data['Case Result'] = '';

		return $excel_data;
	}




	/**
	 * Delete Steps query by testcase id
	 *
	 * @return int
	 */

	public function createExecutionByStep($step, $tl_id, $execution_data)
	{ 
		$execution 				=  \App\Execution::where(['tc_id' => $step->tc_id, 'ts_id' => $step->ts_id])->get()->toArray();
		if(count ($execution) != 0)
		{
			$exe_data 						= $execution[0];
			$exe_data['e_id']				= $tl_id."_".$this->genrateRandomInt(8);
			$exe_data['tl_id']				= $tl_id;
			$exe_data['execution_result'] 	= '';
			$exe_data['checkpoint_result'] 	= '';
			$exe_data['executed_by'] 		= session()->get('email');
			$exe_data['executed_by_name'] 	= session()->get('name');
			unset($exe_data['created_at']);
			unset($exe_data['updated_at']);
			$created_exe 					= \App\Execution::create($exe_data);
			$execution_data['Test Step ID']					= $exe_data['e_id'];
			$execution_data['Test Step Description']		= $step->description;
			$execution_data['Step Result'] 					= '';
		}
		return $execution_data;
	}
}
