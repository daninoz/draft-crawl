<?php

use Illuminate\Database\Migrations\Migration;

class AddFixedPosition extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('players', function($table)
        {
            $table->integer('fixed_position')->nullable()->default(null);
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
            $table->dropColumn('fixed_position');
        });
    }

}