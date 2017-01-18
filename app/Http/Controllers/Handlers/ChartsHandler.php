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
		$chart_details['ex_pass'] = $chart_details['ex_fail'] = $chart_details['ex_not_avail']  = 0;
		$chart_details['cp_pass'] = $chart_details['cp_fail'] = $chart_details['cp_not_avail']  = 0;
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
		    'title' => 'Execution Results : Total Executed Labs = '.$chart_details['status_executed'],
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
		        ->addRow(['Not Executed', $chart_details['status_not_executed']]);
		Lava::PieChart('cp_result', $cp_data, [
		    'title' => 'Checkpoint Results : Total Executed Labs =  '.$chart_details['status_executed'],
		    'colors' => ['#43a047', '#e53935', '#fb8c00', '#1e88e5']
		]);
	}

}
