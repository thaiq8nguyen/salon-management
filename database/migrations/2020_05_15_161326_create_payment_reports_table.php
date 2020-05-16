<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('technician_id')->unsigned();
            $table->foreign('technician_id')->references('id')
                ->on('technicians')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('pay_period_id')->unsigned();
            $table->foreign('pay_period_id')->references('id')
                ->on('pay_periods')->onUpdate('cascade')->onDelete('cascade');
            $table->string('report_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_reports');
    }
}
