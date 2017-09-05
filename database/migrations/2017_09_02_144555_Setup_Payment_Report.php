<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetupPaymentReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_reports', function (Blueprint $table) {
            $table->integer('technician_id')->unsigned()->reference('id')->on('technicians');
            $table->integer('pay_period_id')->unsigned()->reference('id')->on('pay_periods');
            $table->boolean('published')->default(false);
            $table->string('url',2083);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_reports', function (Blueprint $table) {
            //
        });
    }
}
