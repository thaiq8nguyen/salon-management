<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->bigInteger('payment_method_id')->unsigned();
            $table->foreign('payment_method_id')->references('id')
                ->on('payment_methods')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('payment_report_id')->unsigned();
            $table->foreign('payment_report_id')->references('id')
                ->on('payment_reports')->onUpdate('cascade')->onDelete('cascade');
            $table->decimal('amount',10,2)->default(0.0);
            $table->text('note')->nullable();
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
