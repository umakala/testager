<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Handlers\LabHandler;
use App\Http\Controllers\Handlers\DownloadHandler;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DownloadResultFormatController extends Controller {

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

	public function download($type, $id='')
	{	
		$dt 			= Carbon::now()->format('dmyhis');
		$tp_id 			= session()->get('open_project');
		$final_format = [];

		$lab_obj = new LabHandler();
		if($type == "all")
		{
			$scenarios = \App\TestScenario::where('tp_id', $tp_id)->orderBy('seq_no', 'asc')->get() ;
		}
		if($type == "scenario"){
			$scenarios = \App\TestScenario::where('tsc_id', $id)->get() ;
		}
	/*	print_r($final_format);
		exit;*/
		foreach ($scenarios as $sc_value) {
				$format = $lab_obj->createScLabByScenario($sc_value);
				foreach ($format as $key => $value) {
					$final_format[] = $value;
				}
			}
		$download_obj = new DownloadHandler();
		$download_obj->processDownload($final_format, $dt);
		return redirect()->back();
	}	

}
