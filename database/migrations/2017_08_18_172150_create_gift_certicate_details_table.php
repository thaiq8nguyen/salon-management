<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGiftCerticateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gift_certicate_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('gift_certificate_id')->reference('id')->on('gift_certificates');
            $table->dateTime('date');
            $table->decimal('amount',7,2)->default(0.00);
            $table->string('comments');
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
        Schema::dropIfExists('gift_certicate_details');
    }
}
