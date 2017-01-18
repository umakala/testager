<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;

	/**
	 * Generate random number for verification code
	 * 
	 */
	public function genrateRandomInt($x = 5)
	{
		$min   = pow(10, $x);
		$max   = pow(10, $x + 1) - 1;
		$value = rand($min, $max);
		return $value;
	}

	public function getMessage($value)
	{
		return \Config::get($value);
	}

	public function getCountFormatLabs($scenarios_counts, $key)
	{
		$ary['total'] = 0;
		foreach ($scenarios_counts as  $value) {
			switch ($value[$key]) {
				case 'Fail':
				$ary['fail'] =  $value['count'];
				break;

				case 'Pass':
				$ary['pass'] =  $value['count'];
				break;

				case 'not_executed':
				$ary['not_executed'] = $value['count'];
				break;

				case 'executed':
				$ary['executed'] = $value['count'];
				break;

			}
			$ary['total'] +=  $value['count'];
		}
		return $ary;
	}

	public function getCountFormat($scenarios_counts)
	{
		$ary['total'] = 0;
		foreach ($scenarios_counts as  $value) {
			switch ($value['status']) {
				case 'failed':
				$ary['failed'] =  $value['count'];
				break;

				case 'passed':
				$ary['passed'] =  $value['count'];
				break;

				case 'not_executed':
				$ary['not_executed'] = $value['count'];
				break;

				case 'executed':
				$ary['executed'] = $value['count'];
				break;

			}
			$ary['total'] +=  $value['count'];
		}
		return $ary;
	}
}
