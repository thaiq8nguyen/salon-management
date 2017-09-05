<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTechnicianPayPeriodPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technician_pay_period', function (Blueprint $table) {
            $table->integer('technician_id');
            $table->integer('pay_period_id');
            $table->string('payment_report_url',2083);
            $table->primary(['technician_id','pay_period_id']);
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
        Schema::dropIfExists('technician_pay_period');
    }
}
