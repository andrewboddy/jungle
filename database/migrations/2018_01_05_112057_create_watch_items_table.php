<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWatchItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('watch_items', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('watchlist');
            $table->string('ticker');
            $table->string('watching_since_date');
            $table->string('watching_since_price');
            $table->string('price');
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
        Schema::dropIfExists('watch_items');
    }
}
