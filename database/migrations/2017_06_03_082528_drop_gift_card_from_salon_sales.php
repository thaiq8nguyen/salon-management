<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropGiftCardFromSalonSales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salon_sales', function (Blueprint $table) {
            $table->dropColumn(['giftcard_sold', 'giftcard_redeemed'] );
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
