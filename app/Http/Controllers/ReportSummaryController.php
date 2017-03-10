<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Handlers\ChartsHandler;
use Illuminate\Http\Request;

class ReportSummaryController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($tf_id=0)
	{
		$id = session()->get('open_project');
		$functionalities = \App\TestFunctionality::where('tp_id' , $id)->get();
		
		$report['sc_total'] =0;
		$report['total'] = 0;		
		$report['not_available']  =0;
		$report['pass'] = 0;
		$report['fail'] = 0;
		$report['balance'] = 0;

		foreach ($functionalities as $fn) {
			$fn->sc_count = \App\TestScenario::where('tf_id' , $fn->tf_id)->count();
			$report['sc_total']+=$fn->sc_count;			

			$sample = \App\ScenarioLab::select()->where('tf_id' , $fn->tf_id)->groupBy('tsc_id')->get()->toArray();
			//$fn->sc_labs = \App\ScenarioLab::where('tf_id' , $fn->tf_id)->distinct('tsc_id')->count('tsc_id');

			$fn->sc_labs_count = count($sample);
			$report['total']+=$fn->sc_labs_count;

			$fn_pass = 0; $fn_fail = 0;

			foreach ($sample as $key => $value) {
				($value['result'] == "Pass")?$fn_pass+=1: $fn_fail+=1;
			}

			$fn->pass = $fn_pass;
			$report['pass']+=$fn->pass;

			$fn->fail = $fn_fail;
			$report['fail']+=$fn->fail;


			$fn->balance = $fn->sc_count - ($fn->pass + $fn->fail) ;
			$report['balance'] += $fn->balance;

			$fn->not_available = $fn->sc_labs_count - ($fn->pass + $fn->fail);
			$report['not_available'] +=$fn->not_available;
		}
		/*
		$report['not_available'] = $report['total']- ($report['pass'] +$report['fail']);*/


		//Initiate chart objects
		$charts_obj = new ChartsHandler();
		$chart_details = $charts_obj->initChartDetails();
		$charts_obj->createScvsLabSummaryPieChart($report);		
		$charts_obj->createLabSummaryPieChart($report);

		return view('reports.summary', ['functionalities' => $functionalities, 'report'  => $report]);
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
