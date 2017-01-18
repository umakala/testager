<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDefectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('defects', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('defect_id');
			$table->string('defect_status',50);
			$table->text('description');
			$table->string('tp_id',20);
			$table->string('tf_id',20);
			$table->string('ts_id',20);
			$table->string('tc_id',20);
			$table->string('reported_by');
			$table->string('reported_by_name');
			$table->string('release_version');
			$table->foreign('ts_id')->references('ts_id')->on('teststeps');
			$table->foreign('tc_id')->references('tc_id')->on('testcases');
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
		Schema::drop('defects');
	}

}
