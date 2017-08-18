<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGiftCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gift_certificates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('squareId')->unique();
            $table->dateTime('sold_at');
            $table->dateTime('expired_at');
            $table->decimal('amount',7,2)->default('0.00');
            $table->string('user_id')->default('salon');


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
        Schema::dropIfExists('gift_certificates');
    }
}
