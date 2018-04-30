<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('ticker');
            $table->string('name');
            $table->string('sector');
            $table->string('industry');
            $table->integer('mkt_cap');
            $table->string('exchange');
            $table->decimal('eps_f0',8,2);
            $table->decimal('eps_f1',8,2);
            $table->decimal('eps_f2',8,2);
            $table->decimal('pe_ttm',8,2);
            $table->decimal('pe_f1',8,2);
            $table->decimal('pe_f2',8,2);
            $table->decimal('peg_ratio',8,2);
            $table->decimal('div_yield',8,2);
            $table->decimal('net_margin',8,2);
            $table->decimal('change_f1_est_4_weeks',8,2);
            $table->decimal('change_f2_est_4_weeks',8,2);
            $table->decimal('change_ltg_est_4_weeks', 6,2);
            $table->decimal('last_eps_surprise',8,2);
            $table->decimal('prev_eps_surprise',8,2);
            $table->decimal('avg_eps_surprise_last_4_q',8,2);
            $table->integer('next_earnings_call');
            $table->integer('year_end');
            $table->decimal('debt_total_capital',7,5);
            $table->decimal('growth1',8,2);
            $table->decimal('growth2',8,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
}
