<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTechnicianSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technician_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('date_id')->unsigned();
            $table->foreign('date_id')->references('id')->on('dates');
            $table->integer('technician_id')->unsigned();
            $table->foreign('technician_id')->references('id')->on('technicians');
            $table->timestamp('from');
            $table->timestamp('to');

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
        Schema::dropIfExists('technician_schedules');
    }
}
