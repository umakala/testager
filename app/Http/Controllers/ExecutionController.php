<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DownloadController;
use Illuminate\Http\Request;
use File;
use Toast;

class ExecutionController extends Controller{

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
		$lab_conditions['tp_id'] 		= session()->get('open_project');
		$lab_conditions['tc_id'] 		= $id;
		$lab_conditions['executed_by'] 	= session()->get('email');

		$lab[] = \App\Lab::where($lab_conditions)->orderBy('created_at', 'desc')->first();		
		$case = \App\Testcase::find($id);
		$this->execute($lab[0]->executed_filename);
		//return view('testlab.execute', ['lab_details' => $lab, 'case' => $case]);
		return redirect()->back();
	}


	public function execute($filename)
	{
		$argument = $filename;
		$cmd = 'echo %home%';
		$home = shell_exec($cmd);
		$exe_location = trim($home)."\Desktop\AutoRun.appref-ms";
		$xls_location = trim($home)."\Downloads\\".$filename.".xls";
		//print_r(pathinfo('AutoRun.appref-ms'));

		if(File::exists($exe_location)){
			
			if(File::exists($xls_location)){
				$message = $this->getMessage('messages.execution_start');
				Toast::message($message, 'info');	
				$answer = shell_exec("$exe_location " .$argument);
			}
			else{
				$message = $this->getMessage('messages.xls_not_found');
				Toast::message($message." - $filename", 'danger');
			}
		}
		else
		{
			$message = $this->getMessage('messages.exe_not_found');
			Toast::message($message, 'danger');
		}
		//echo $answer."</br>"; 
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
