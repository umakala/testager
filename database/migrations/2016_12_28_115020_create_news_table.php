<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('news', function(Blueprint $table)
		{
			$table->increments('news_id');
			$table->string('title');
			$table->string('reporter_email');
			$table->longText('text');
			$table->string('image');					
			$table->timestamps();
			$table->foreign('reporter_email')->references('email')->on('users');
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
		Schema::drop('news');
	}

}
