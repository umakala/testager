<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('labs', function(Blueprint $table)
		{			
            $table->string('tl_id')->primary();
			$table->string('tp_id',20);
			$table->string('tc_id',20);
			$table->string('tf_id',20);
			$table->string('bug_id',20);
			$table->string('tc_status', 50);
			$table->string('execution_type', 50);
			$table->string('executed_by');
			$table->string('executed_by_name');
			$table->foreign('tc_id')->references('tc_id')->on('testcases');
			$table->foreign('tf_id')->references('tf_id')->on('testfunctionalities');
			$table->foreign('tp_id')->references('tp_id')->on('testprojects');			
			$table->timestamps();
		});

       /* Schema::table('executions', function($table)
        {
            $table->dropPrimary('l_id');
            $table->string('tl_id')->primary();
        });*/
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('labs');
	}

}
