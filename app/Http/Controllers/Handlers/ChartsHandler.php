<?php namespace App\Http\Controllers\Handlers;

use Lava;

class ChartsHandler {

	/**
	 * Send email using PHP Mailer .
	 *
	 * @return int
	 */

	public function initChartDetails()
	{
		$chart_details['ex_pass'] = $chart_details['ex_fail'] = $chart_details['ex_not_avail']   = 0;
		$chart_details['cp_pass'] = $chart_details['cp_fail'] = $chart_details['cp_not_avail'] = $chart_details['cp_not_defined'] = 0;
		$chart_details['status_executed'] = $chart_details['status_not_executed'] = 0;
		return $chart_details;
	}


	public function getChartSummary($value, $chart_details)
	{
		if(strtolower($value['tc_status']) == "executed")
		{
			$chart_details['status_executed']++;
			switch (strtolower($value['execution_result'])) {
				case 'pass':
					$chart_details['ex_pass']++;
					break;
				case 'fail':
					$chart_details['ex_fail']++;
					break;
				case '':				
					$chart_details['ex_not_avail']++;
					break;
			}
			switch (strtolower($value['checkpoint_result'])) {
				case 'pass':
					$chart_details['cp_pass']++;
					break;
				case 'fail':
					$chart_details['cp_fail']++;
					break;
				case 'none':
					$chart_details['cp_not_defined']++;
					break;
				case '':
					$chart_details['cp_not_avail']++;
					break;
			}
		}
		else
			$chart_details['status_not_executed']++;

		return $chart_details;
	}

	public function createExecutionPieChart($chart_details)
	{
		$exe_data = Lava::DataTable();
		$exe_data->addStringColumn('Summary')
		        ->addNumberColumn('Percent')
		        ->addRow(['Pass', $chart_details['ex_pass']])
		        ->addRow(['Fail', $chart_details['ex_fail']])
		        ->addRow(['Not Available', $chart_details['ex_not_avail']])
		        ->addRow(['Not Executed', $chart_details['status_not_executed']]);

		Lava::PieChart('exe_result', $exe_data, [
		    'title' => 'Execution Results : Total Executed = '.$chart_details['status_executed'],
		    'colors' => ['#43a047', '#e53935', '#fb8c00', '#1e88e5']
		]);

	}

	public function createCheckpointPieChart($chart_details)
	{
		$cp_data = Lava::DataTable();
		$cp_data->addStringColumn('Summary')
		        ->addNumberColumn('Percent')
		        ->addRow(['Pass', $chart_details['cp_pass']])
		        ->addRow(['Fail', $chart_details['cp_fail']])
		        ->addRow(['Not Available', $chart_details['cp_not_avail']])
		        ->addRow(['Not Executed', $chart_details['status_not_executed']])
		        ->addRow(['Not Defined', $chart_details['cp_not_defined']]);

		Lava::PieChart('cp_result', $cp_data, [
		    'title' => 'Checkpoint Results : Total Executed =  '.$chart_details['status_executed'],
		    'colors' => ['#43a047', '#e53935', '#fb8c00', '#1e88e5', '#9e9e9e']
		]);
	}

public function createSummaryColumnChart($chart_details)
	{
		$summary = Lava::DataTable();

		$summary->addStringColumn('Number')
		         ->addNumberColumn('Cases')
		         ->addNumberColumn('Labs')
		         ->addRow(['Functionalities', 1000, 400])
		         ->addRow(['Scenarios', 1170, 460])
		         ->addRow(['Cases', 660, 1120])
		         ->addRow(['Steps', 1030, 54]);

		Lava::ColumnChart('Summary', $summary, [
		    'title' => ''
		   /* 'titleTextStyle' => [
		        'color'    => '#eb6b2c',
		        'fontSize' => 14
		    ]*/
		]);
	}

}
