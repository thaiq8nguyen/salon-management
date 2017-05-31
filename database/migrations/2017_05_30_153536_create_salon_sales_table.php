<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalonSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salon_sales', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->decimal('gross_sales',7,2)->default(0.0)->unsigned();
            $table->decimal('giftcard_sold',7,2)->default(0.0);
            $table->decimal('giftcard_redeemed',7,2)->default(0.0);
            $table->decimal('tips',7,2)->default(0.0);
            $table->decimal('fees',7,2)->default(0.0);
            $table->decimal('cash_collected',7,2)->default(0.0);
            $table->decimal('cards_collected',7,2)->default(0.0);
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
        Schema::dropIfExists('salon_sales');
    }
}
