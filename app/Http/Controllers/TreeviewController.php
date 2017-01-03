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
	  		$tree_node = array();
	  		$tree_node['text'] = $p_value->tp_name;
	  		$url = route('profile');
			$tree_node['href'] = $url;//"#".$p_value->tp_id;
			
			$testfunctionalities = \App\TestFunctionality::where('tp_id', $p_value->tp_id)->get();
			foreach ($testfunctionalities as $functionality) {
				//Repeat same for scenarios
				$f_node = array();
				$f_node['text'] = $functionality->tf_name;
				$testscenarios = \App\TestScenario::where(['tp_id' => $p_value->tp_id , 'tf_id' => $functionality->tf_id ])->get();
				foreach ($testscenarios as $scenario) {
					//Repeat same for cases				
					$s_node = array();
					$s_node['text'] = $scenario->tsc_name;
					$testcases = \App\TestCase::where(['tp_id' => $p_value->tp_id , 'tsc_id' => $scenario->tsc_id ])->get();
					foreach ($testcases as $case) {
						$c_node = array();
						$c_node['text'] = $case->tc_name;	
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
