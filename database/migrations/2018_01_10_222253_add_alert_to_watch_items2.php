<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAlertToWatchItems2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('watch_items', function (Blueprint $table) {

            /* price is below the alert so the logic is

            echo (is_alert_resistance?
                    (price > alert ? "ALERT" : "not broken resistance")
                    :price < alert ? "ALERT" : "not broken support")
                )

            */
            $table->boolean('is_alert_resistance');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('watch_items', function (Blueprint $table) {
            //
        });
    }
}
