<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateETFsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etfs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('etf');
            $table->string('name');
            $table->decimal('price', 6,2);
            $table->date('watching_since_date');
            $table->decimal('watching_since_price', 6,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etfs');
    }
}
