<?php

use Illuminate\Database\Migrations\Migration;

class Seasons extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('seasons', function ($table)
        {
            $table->increments('id');
            $table->string('year');
            $table->timestamps();
        });

        Schema::create('player_season', function ($table)
        {
            $table->double('per');
            $table->integer('games');
            $table->integer('player_id')->unsigned();
            $table->integer('season_id')->unsigned();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('player_season');
        Schema::drop('seasons');
	}

}