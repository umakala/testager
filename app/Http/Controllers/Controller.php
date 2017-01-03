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
}
