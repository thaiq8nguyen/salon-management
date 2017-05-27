<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWagePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wage_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('technician_id')->unsigned();
            $table->integer('pay_period_id')->unsigned();
            $table->decimal('amount',5,2)->default(0.0)->unsigned();
            $table->string('reference')->nullable();
            $table->string('method')->nullable();
            $table->date('pay_date');
            $table->string('expense_account')->nullable();

            $table->foreign('technician_id')->references('id')->on('technicians');
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
        Schema::dropIfExists('wage_payments');
    }
}
