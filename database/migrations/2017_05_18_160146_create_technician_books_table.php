<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTechnicianBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technician_books', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('technician_id')->unsigned();
            $table->integer('pay_period_id')->unsigned()->nullable();
            $table->date('date');
            $table->string('description')->nullable()->default('none');
            $table->string('reference')->nullable()->default('none');
            $table->decimal('receive',6,2)->default(0.0);
            $table->decimal('pay', 6,2 )->default(0.0);
            $table->decimal('balance',7,2)->default(0.0);

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
        Schema::dropIfExists('technician_books');
    }
}
