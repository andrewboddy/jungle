<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddManyOnStocks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->text('long_description');
            $table->decimal('eps_q1',8,2);
            $table->decimal('eps_q2',8,2);
            $table->decimal('eps_q3',8,2);
            $table->decimal('eps_q4',8,2);
            $table->decimal('eps_q5',8,2);
            $table->decimal('eps_q6',8,2);
            $table->decimal('eps_q7',8,2);
            $table->decimal('eps_q8',8,2);
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
