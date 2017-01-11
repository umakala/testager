<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExecutionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('executions', function(Blueprint $table)
		{
			//$table->increments('id');	
			$table->string('e_id')->primary();
			$table->string('scroll');
			$table->string('resource-id');								
			$table->string('text');
			$table->string('Content-desc');
			$table->string('class');
			$table->string('index');
			$table->string('sendkey');
			$table->string('screenshot', 10);
			$table->string('checkpoint');
			$table->string('wait');
			$table->string('execution_result',50);
			$table->string('checkpoint_result',50);
			$table->string('executed_by');
			$table->string('executed_by_name');
			$table->timestamps();	
			$table->string('tc_id');			
			$table->string('ts_id');
			$table->string('tp_id');
			$table->foreign('tc_id')->references('tc_id')->on('testcases');
			$table->foreign('ts_id')->references('ts_id')->on('teststeps');
			$table->foreign('tp_id')->references('tp_id')->on('testprojects');
		});

 		/*  
        Schema::table('executions', function($table)
        {
            $table->dropPrimary('id');          
        });
     
        Schema::table('executions', function($table)
        {           
           $table->string('execution_id')->primary();
        });*/
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
