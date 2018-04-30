<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuarters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->integer('q0_date');
            $table->decimal('q0_eps', 8,2);
            $table->decimal('q0_actual', 8,2);
            $table->decimal('q1_eps', 8,2);
            $table->decimal('q2_eps', 8,2);
            $table->integer('q0_change_4_weeks');
            $table->integer('q1_change_4_weeks');
            $table->integer('q2_change_4_weeks');
            $table->integer('q0_n_analysts');
            $table->integer('q1_n_analysts');
            $table->integer('q2_n_analysts');
        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stocks', function (Blueprint $table) {
            //
        });
    }
}
