<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScenarioLabsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('scenariolabs', function(Blueprint $table)
		{			
            $table->string('scl_id')->primary();
			$table->string('tp_id',20);
			$table->string('tc_id',20);
			$table->string('tsc_id',20);
			$table->string('tf_id',20);
			$table->string('result', 50);
			$table->string('execution_type', 50);
			$table->string('executed_by');
			$table->foreign('tc_id')->references('tc_id')->on('testcases');
			$table->foreign('tsc_id')->references('tsc_id')->on('testscenarios');
			$table->foreign('tf_id')->references('tf_id')->on('testfunctionalities');
			$table->foreign('tp_id')->references('tp_id')->on('testprojects');			
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
