<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterLabsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('labs', function($table)
        {
            $table->string('os_version'); 
            $table->string('device_name');
            $table->string('network_type');
            $table->dateTime('execution_start_time');          
            $table->dateTime('execution_end_time');       
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
