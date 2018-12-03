<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('full_date'); //2017-10-17
            $table->string('day'); //Wednesday
            $table->string('month_number'); //10
            $table->string('month_name'); //October
            $table->string('day_number_of_week'); //4
            $table->string('day_number_of_month'); //17
            $table->string('number_of_days_in_month'); //31
            $table->string('number_of_days_in_year');//365
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
        Schema::dropIfExists('dates');
    }
}
