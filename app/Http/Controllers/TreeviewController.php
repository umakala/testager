<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class TreeviewController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($id)
	{
		$user = \App\User::where('email',session()->get('email'))->update(['open_project' => $id]);
		session(['open_project' => $id]);

		$p_value = \App\TestProject::find($id);
	  	$tree = array();
	  	//foreach ($projects as $key => $p_value) {
	  		//Take each project node and find associated functionalities 
	  		$testfunctionalities = \App\TestFunctionality::where('tp_id', $p_value->tp_id)->get();
			$tp_count = count($testfunctionalities);
			
	  		$tree_node = array();
	  		$tree_node['text'] =  $p_value->tp_name;
			$tree_node['tags']  = [$tp_count];
			$tree_node['backColor']  = '#dddfd4';

	  		$url = route('project.show' , ['id' => $id] );
			$tree_node['href'] = $url;//"#".$p_value->tp_id;
			
			foreach ($testfunctionalities as $functionality) {
				//Repeat same for scenarios
				$testscenarios = \App\TestScenario::where(['tp_id' => $p_value->tp_id , 'tf_id' => $functionality->tf_id ])->get();
				$tsc_count = count($testscenarios);

				$f_node = array();
				$f_node['text'] = $functionality->tf_name;
				$f_node['href'] = route('functionality.show' , ['id' => $functionality->tf_id] );
				$f_node['tags']  = [$tsc_count];
				$f_node['backColor']  = '#c9d8c5';

				foreach ($testscenarios as $scenario) {
					//Repeat same for cases	
					$testcases = \App\TestCase::where(['tp_id' => $p_value->tp_id , 'tsc_id' => $scenario->tsc_id ])->get();
					$tc_count = count($testcases);

					$s_node = array();
					$s_node['text'] = $scenario->tsc_name;
					$s_node['href'] = route('scenario.show' , ['id' => $scenario->tsc_id] );
					$s_node['tags']  = [$tc_count];
					$s_node['backColor']  = '#e9ece5';
			
					foreach ($testcases as $case) {
						$teststeps = \App\TestStep::where(['tp_id' => $p_value->tp_id , 'tc_id' => $case->tc_id ])->get();
						$ts_count = count($teststeps);
						$c_node = array();
						$c_node['text'] = $case->tc_name;	
						$c_node['href'] = route('testcase.show' , ['id' => $case->tc_id] );
						$c_node['tags']  = [$ts_count];

						/*
						//Child node of test cases is test step and there node details added below
						foreach ($teststeps as $step) {
							$st_node = array();
							$st_node['text'] = "St - ".$step->description;	
							$st_node['href'] = route('teststep.show' , ['id' => $step->ts_id] );
							$c_node['nodes'][] = $st_node;
						}*/
						//create node for case and add to scenario
						$s_node['nodes'][] = $c_node;			
					}
					//create node for scenario and add to functionality
					$f_node['nodes'][] = $s_node;
				}
				//create node for functionality and add to project 
	  			$tree_node['nodes'][] = $f_node ;	  			
			}	
			//eventually forming the data for tree node
			$tree[] = $tree_node;
	  	//}
	  	//return tree format data
	  	return $tree;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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
