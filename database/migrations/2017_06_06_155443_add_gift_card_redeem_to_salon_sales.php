<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGiftCardRedeemToSalonSales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salon_sales', function (Blueprint $table) {
            $table->decimal('gift_certificate_redeemed',7,2)->default(0.0)->after('cards_collected');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salon_sales', function (Blueprint $table) {
            //
        });
    }
}
