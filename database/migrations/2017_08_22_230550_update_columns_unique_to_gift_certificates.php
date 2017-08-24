<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColumnsUniqueToGiftCertificates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gift_certificates', function (Blueprint $table) {
            $table->dropIndex('gift_certificates_squareid_unique');
            $table->unique(['squareId','amount']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gift_certificates', function (Blueprint $table) {
            //
        });
    }
}
