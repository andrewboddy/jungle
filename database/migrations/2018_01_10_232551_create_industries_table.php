<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndustriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('industries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sector');
            $table->string('industry');

            $table->tinyInteger('pe0');
            $table->tinyInteger('pe1');
            $table->tinyInteger('pe2');

            $table->decimal('eps0', 5, 2);
            $table->decimal('eps1', 5, 2);
            $table->decimal('eps2', 5, 2);

            $table->decimal('g1', 8, 2);
            $table->decimal('g2', 8, 2);

            $table->decimal('peg1', 5, 2);
            $table->decimal('peg2', 5, 2);

            $table->string('notes');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('industries');
    }
}
