<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use File;
use Illuminate\Http\Request;
use Excel;
use Toast;
use Input;

class IntegrationHandler extends Controller{

	/**
	 * Handles the functionality part of the row from excel
	 *
	 * @return fn_id
	 */
	public function handleFunctionality($row, $fn_id)
	{		
       $fn = [];
       /*if(isset($row['functionality_name']))
       {*/
        if(!isset($row['functionality_name']) || $row['functionality_name']  == null ||  $row['functionality_name'] == ""){
			//If nothing to process then do nothing
			//return $fn_id;
           }else{
              $fn['tf_name']      = $row['functionality_name'];
              $fn['description']  = $row['functionality_description'];
              $fn['created_by']   = session()->get('email');
              $fn['tp_id']        = session()->get('open_project');
              $fn_check           =  \App\TestFunctionality::where($fn)->first();
              if($fn_check!= null && $fn_check->exists == 1)	{
                  $fn_id          = $fn_check->tf_id;
              }
              else
              {
                  $fn_id = $fn['tf_id'] = $this->genrateRandomInt();
                  try{
                    \App\TestFunctionality::create($fn);       	
                  }catch(Exception $e){

                  }	
              }
          }
      /*}
      else{
        $fn_id =0;
      }*/
    return $fn_id;
}

	/**
	 * Handles the scenario part of the row from Excel
	 *
	 * @return sc_id
	 */
	public function handleScenario($row, $fn_id, $sc_id, $seq)
	{		
       $sc = [];
       /*if( isset($row['sceanrio_brief'] )){*/
           if(!isset($row['sceanrio_name']) || $row['sceanrio_name']  == null ||  $row['sceanrio_name'] == ""){
			//If nothing to process then do nothing
			//return $fn_id;
           }else{
              $sc['tsc_name']              = $row['sceanrio_name'];
              $sc['scenario_brief'] 		   = $row['sceanrio_brief'];
              $sc['description'] 		       = $row['sceanrio_description'];
              $sc['expected_result'] 	     = $row['scenario_expected_result'];

              $sc['seq_no']             = $seq;

              $sc['tp_id'] 			= session()->get('open_project');
              $sc['tf_id'] 			= $fn_id;
              $sc_check 				=  \App\TestScenario::where($sc)->first();
        	//print_r($sc_check);
              if($sc_check!= null && $sc_check->exists == 1)	{
                  $sc_id  = $sc_check->tsc_id;
              }
              else
              {
                  $sc_id = $sc['tsc_id'] = $fn_id."_".$this->genrateRandomInt();
                  \App\TestScenario::create($sc);
              }
          }
     /* }else{
        $sc_id =0;
    }*/
    return $sc_id;
}

	/**
	 * Handles the testcase part of the row from excel
	 *
	 * @return tc_id
	 */
	public function handleTestcase($row, $sc_id, $tc_id, $seq)
	{
       $tc = [];
      /* if( isset($row['test_case_name'])){
        */   if( !isset($row['test_case_name'])  || $row['test_case_name']  == null ||  $row['test_case_name'] == ""){
			//If nothing to process then do nothing
			//return $fn_id;
           }else{
              $tc['tc_name'] 			      = $row['test_case_name'];
              $tc['description'] 		    = $row['test_case'];
              $tc['expected_result'] 	  = $row['test_case_expected_result'];
              if(isset($row['priority']))
                $tc['tc_priority']      = $row['priority'];
              else
                $tc['tc_priority']      = "";

              $tc['tp_id'] 			        = session()->get('open_project');
              $tc['tsc_id'] 			      = $sc_id;
              $tc['seq_no']             = $seq;

              $tc_check 				        =  \App\TestCase::where($tc)->first();
              if($tc_check!= null && $tc_check->exists == 1)	{
                  $tc_id  = $tc_check->tc_id;
              }
              else
              {
                  $tc_id = $tc['tc_id'] = $sc_id."_". $this->genrateRandomInt();
                  $tc['status'] = 'not_executed';        		
                  \App\TestCase::create($tc);
              }
          } 
        /*}else{
            $tc_id =0;
        }*/
        return $tc_id;
    }

  public function handleExecution($row, $tc_id, $ts_id, $seq)
  {
    $ts = [];
    $execution_content = [];   
    if(!isset($row['description'])|| $row['description']  == null ||  $row['description'] == ""){
          return 0;
       }else{
          $ts['description']      = $row['description'];
          $ts['expected_result']  = $row['expected_value'];
          $ts['tp_id']      = session()->get('open_project');
          $ts['tc_id']      = $tc_id;

          //$check          =  \App\TestStep::where($ts)->first();        
          //echo "its null";
          $ts_id = $ts['ts_id'] = $tc_id."_".$this->genrateRandomInt();
          $ts['status']         = 'not_executed';
          $ts['created_by']     = session()->get('email');
          $ts['seq_no']         = $seq;
          \App\TestStep::create($ts);


          $execution_content['scroll']        = $row['scroll'];
          $execution_content['seq_no']        = $seq;

          if($row['resource_id'] == null)
          $execution_content['resource_id']   = '';
          else
          $execution_content['resource_id']   = $row['resource_id'];

          if($row['text'] == null)
            $execution_content['text']        = '';
          else
            $execution_content['text']        = $row['text'];

          if($row['content_desc'] == null)
          $execution_content['content_desc']  = '';
          else 
          $execution_content['content_desc']  = $row['content_desc'];

          if($row['class'] == null)
          $execution_content['class']         = '';
          else
          $execution_content['class']         = $row['class'];

          if($row['index'] == null)
          $execution_content['index']         = '';
          else
          $execution_content['index']         = $row['index'];

          if($row['sendkey'] == null)
          $execution_content['sendkey']       = '';
          else
          $execution_content['sendkey']       = $row['sendkey'];
          //echo ($row['sendkey']);
    
          if($row['screenshot'] == null)
          $execution_content['screenshot']          = '';
          else
          $execution_content['screenshot']          = $row['screenshot'];

          if($row['check_point'] == null)
            $execution_content['checkpoint']        = '';
          else
            $execution_content['checkpoint']        = $row['check_point'];

          if($row['wait'] == null)
            $execution_content['wait']              = '';
          else
            $execution_content['wait']              = $row['wait'];

          $execution_content['tc_id']         = $tc_id;
          $execution_content['tp_id']         = session()->get('open_project');
          $execution_content['ts_id']         = $ts_id;
          $execution_content['e_id']          = $ts_id."_".$this->genrateRandomInt(8);

          \App\Execution::create($execution_content); 
      }

    return $ts_id;   
  }

/**
	 * Handles the teststep part of the row from excel
	 *
	 * @return ts_id
	 */
public function handleTeststep  ($row, $tc_id, $ts_id, $seq)
{
   $ts = [];
    if(!isset($row['test_step'])|| $row['test_step']  == null ||  $row['test_step'] == ""){
			//If nothing to process then do nothing
			//return $ts_id;
       }else{
          $ts['description'] 		= $row['test_step'];
          $ts['expected_result'] 	= $row['ts_expected_result'];
          $ts['tp_id'] 			= session()->get('open_project');
          $ts['tc_id'] 			= $tc_id;
          $check 					=  \App\TestStep::where($ts)->first();
          if($check == null)
          {
        		//echo "its null";
              $ts_id = $ts['ts_id'] = $tc_id."_".$this->genrateRandomInt();
              $ts['status']         = 'not_executed';
              $ts['created_by']     = session()->get('email');
              $ts['seq_no']         = $seq;


              \App\TestStep::create($ts);
              $execution_content['scroll']        = 'No';
              $execution_content['resource_id']   = '';
              $execution_content['text']          = '';
              $execution_content['content_desc']  = '';
              $execution_content['class']         = '';
              $execution_content['index']         = '';
              $execution_content['sendkey']       = '';
              $execution_content['screenshot']    = 'No';
              $execution_content['checkpoint']    = '';
              $execution_content['wait']          = '';
              $execution_content['tc_id']         = $tc_id;
              $execution_content['tp_id']         = session()->get('open_project');
              $execution_content['ts_id']         = $ts_id;
              $execution_content['tl_id']         = 0;
              $execution_content['seq_no']        = $seq;
              $execution_content['e_id']          = $ts_id."_".$this->genrateRandomInt();
              \App\Execution::create($execution_content);
          }
          else{
              $ts_id  = $check->ts_id;
          }
      }
  return $ts_id;
  }




  /**
   * Handles the scenario part of the row from Excel
   *
   * @return sc_id
   */
  public function handleResultScenario($row, $fn_id, $sc_id, $seq)
  {   
       $sc = [];
       /*if( isset($row['sceanrio_brief'] )){*/
           if(!isset($row['sceanrio_name']) || $row['sceanrio_name']  == null ||  $row['sceanrio_name'] == ""){
      //If nothing to process then do nothing
      //return $fn_id;
           }else{
              $sc['tsc_name']              = $row['sceanrio_name'];
              $sc['scenario_brief']        = $row['sceanrio_brief'];
              $sc['description']           = $row['sceanrio_description'];
              $sc['expected_result']       = $row['scenario_expected_result'];
              $sc['seq_no']             = $seq;

              $sc['tp_id']      = session()->get('open_project');
              $sc['tf_id']      = $fn_id;
              $sc_check         =  \App\TestScenario::where($sc)->first();
              //print_r($sc_check);
              if($sc_check!= null && $sc_check->exists == 1)  {
                  $sc_id  = $sc_check->tsc_id;
              }
              else
              {
                  $sc_id = $sc['tsc_id'] = $this->genrateRandomInt();
                  \App\TestScenario::create($sc);
              }
          }
     /* }else{
        $sc_id =0;
    }*/
    return $sc_id;
  }



  /**
   * Handles the functionality part of the db to convert to excel Format
   *
   * @return fn_id
   */
  public function handleFunctionalityDbtoXlS($id, $excel)
  {   
    $tf           = \App\TestFunctionality::where('tp_id' , $id)->get();
    //$excel_data   = 
    foreach ($tf as $tf_value) {

      $excel_data['Functionality Name'] = $tf_value->tf_name;
      $excel_data['Functionality Description'] = $tf_value->description;

      $scs   = \App\TestScenario::where('tf_id', $tf_value->tf_id);
      foreach ($scs as $sc) {
       
      $excel_data['Scenario Name'] = $sc->tsc_name;
      $excel_data['Scenario Brief'] = $sc->sceanrio_brief;
      $excel_data['Scenario Description'] = $sc->description;
      $excel_data['Scenario Expected Result']   = $sc->scenario_expected_result;

      }          
    }

    return $fn_id;
}





}
