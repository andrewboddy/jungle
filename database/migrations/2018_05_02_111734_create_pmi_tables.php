<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePmiTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pmi_industries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('is_manufacturing');
        });

        // Remove: pmi_indexes
        Schema::create('pmi_periods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('index');
            $table->boolean('is_manufacturing');
            $table->boolean('historical')->default(false);
        });

        Schema::create('pmi_ranks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pmi_industry_id');
            $table->unsignedInteger('pmi_period_id');
            $table->smallInteger('rank');
            $table->foreign('pmi_industry_id')->references('id')->on('pmi_industries');
            $table->foreign('pmi_period_id')->references('id')->on('pmi_periods');
        });

        Schema::create('pmi_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pmi_industry_id');
            $table->unsignedInteger('pmi_period_id');
            $table->text('comment');
            $table->foreign('pmi_industry_id')->references('id')->on('pmi_industries');
            $table->foreign('pmi_period_id')->references('id')->on('pmi_periods');
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
    }
}
