<?php namespace App\Http\Controllers\Handlers;

use App\Http\Controllers\Controller;
use Toast;

class CloneHandler  extends Controller{



	/*
		Clone all test cases for given FROM from_tsc_id to TO to_tsc_id
	*/
	public function cloneAllScenarios($from_tf_id, $to_tf_id, $allCases)
	{
		$collection = \App\TestScenario::where('tf_id' , $from_tf_id)->get()->toArray();
		foreach ($collection as $value) {
	        //clone all cases for this testcase
	        //echo "Cloning case -  ".$value['tc_name']."<br/>";
	        $old_tsc_id 		= $value['tsc_id'] ;
			$value['tsc_id']= $this->genrateRandomInt();
			$value['tf_id']	= $to_tf_id;
			$value['tp_id'] = session()->get('open_project');
			$value['status']= 'not_executed';
			$value['created_by']= session()->get('email');

			\App\TestScenario::create($value);
			if($allCases == true)
				$this->cloneAllCases($old_tsc_id, $value['tsc_id'], true);
		}
		return;
	}


	/*
		Clone all test cases for given FROM from_tsc_id to TO to_tsc_id
	*/
	public function cloneAllCases($from_tsc_id, $to_tsc_id, $allSteps)
	{
		$collection = \App\TestCase::where('tsc_id' , $from_tsc_id)->get()->toArray();
		foreach ($collection as $value) {
	        //clone all steps for this testcase

	        //echo "Cloning case -  ".$value['tc_name']."<br/>";

	        $old_tc_id 		= $value['tc_id'] ;
			$value['tc_id'] = $this->genrateRandomInt();
			$value['tsc_id']= $to_tsc_id;
			$value['tp_id'] = session()->get('open_project');
			$value['status']= 'not_executed';
			\App\TestCase::create($value);
			if($allSteps == true)
				$this->cloneAllSteps($old_tc_id, $value['tc_id']);
		}
		return;
	}


	/*
		Clone all test steps and executions for given FROM testcase id to TO testcase id
	*/
	public function cloneAllSteps($from_tc_id, $to_tc_id)
	{
		$steps = \App\TestStep::where('tc_id' , $from_tc_id)->get()->toArray();
		foreach ($steps as $value) {
	        //clone all steps for this testcase
	        $old_ts_id = $value['ts_id'] ;
			$value['ts_id'] = $this->genrateRandomInt();
			$value['tc_id'] = $to_tc_id;
			$value['tp_id'] = session()->get('open_project');
			$value['status']= 'not_executed';
			$value['created_by']	= session()->get('email');
			\App\TestStep::create($value);

	        //Add entry in execution table for this step
			$exe 			= \App\Execution::where(['ts_id' => $old_ts_id, 'tl_id' => 0 ])->get()->toArray();
			$exe[0]['e_id'] 	= "0_".$this->genrateRandomInt(8);
			$exe[0]['ts_id'] 	= $value['ts_id'] ;
			$exe[0]['tp_id'] 	= session()->get('open_project');
			$exe[0]['tc_id'] 	= $value['tc_id'] ;
			\App\Execution::create($exe[0]);
		}
		return;
	}

}
