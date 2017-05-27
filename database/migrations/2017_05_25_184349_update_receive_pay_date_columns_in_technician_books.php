<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateReceivePayDateColumnsInTechnicianBooks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('technician_books', function (Blueprint $table) {
            $table->dateTime('date')->change();
            $table->dropColumn('receive');
            $table->dropColumn('pay');
            $table->decimal('sales',8,2)->default(0.0);
            $table->decimal('payments',8,2)->default(0.0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('technician_books', function (Blueprint $table) {
            //
        });
    }
}
