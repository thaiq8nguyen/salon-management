<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToPayPeriodIdInWagePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wage_payments', function (Blueprint $table) {
            $table->foreign('pay_period_id')->references('id')->on('pay_periods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wage_payments', function (Blueprint $table) {
            //
        });
    }
}
