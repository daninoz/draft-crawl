<?php

use Illuminate\Database\Migrations\Migration;

class CreateTablesV1 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('players', function($table)
        {
            $table->increments('id');
            $table->string('name');
            $table->integer('draft');
            $table->integer('position');
            $table->string('link');
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
		Schema::drop('players');
	}

}