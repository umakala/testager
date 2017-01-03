<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestprojectTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('testprojects', function(Blueprint $table)
		{
			$table->string('tp_id')->primary();
			$table->text('tp_name');
			$table->text('release');								
			$table->timestamps();		
		});
		Schema::create('testfunctionalities', function(Blueprint $table)
		{
			$table->string('tf_id')->primary();
			$table->text('tf_name');
			$table->text('description');								
			$table->timestamps();
			$table->string('tp_id');	
			$table->foreign('tp_id')->references('tp_id')->on('testprojects');	
		});

		Schema::create('testscenarios', function(Blueprint $table)
		{
			$table->string('tsc_id')->primary();
			$table->text('tsc_name');
			$table->text('description');
			$table->text('expected_result');					
			$table->string('status');						
			$table->timestamps();	

			$table->string('tp_id');
			$table->string('tf_id');

			$table->foreign('tp_id')->references('tp_id')->on('testprojects');
			$table->foreign('tf_id')->references('tf_id')->on('testfunctionalities');		
		});

		Schema::create('testcases', function(Blueprint $table)
		{
			$table->string('tc_id')->primary();
			$table->text('tc_name');
			$table->text('description');
			$table->text('expected_result');					
			$table->string('status');						
			$table->timestamps();	

			$table->string('tsc_id');
			$table->string('tp_id');
			$table->foreign('tsc_id')->references('tsc_id')->on('testscenarios');
			$table->foreign('tp_id')->references('tp_id')->on('testprojects');
		});

		Schema::create('teststeps', function(Blueprint $table)
		{
			$table->string('ts_id')->primary();
			$table->text('ts_name');
			$table->text('description');			
			$table->text('execution_format');
			$table->text('expected_result');					
			$table->string('status');						
			$table->timestamps();
			$table->string('tc_id');
			$table->string('tp_id');
				
			$table->foreign('tc_id')->references('tsc_id')->on('testcases');
			$table->foreign('tp_id')->references('tp_id')->on('testprojects');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('testprojects');		
		Schema::drop('testfunctionalities');
		Schema::drop('testscenarios');
		Schema::drop('testcases');
		Schema::drop('teststeps');
	}
}
