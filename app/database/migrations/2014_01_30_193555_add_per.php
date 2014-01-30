<?php

use Illuminate\Database\Migrations\Migration;

class AddPer extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('players', function($table)
        {
            $table->double('per')->nullable()->default(null);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('players', function($table)
        {
            $table->dropColumn('per');
        });
	}

}