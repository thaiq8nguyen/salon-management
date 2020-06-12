<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechnicianDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technician_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("technician_id")->unsigned();
            $table->foreign("technician_id")->references("id")
                ->on("technicians")->onUpdate("cascade")->onDelete("cascade");
            $table->decimal("commission_rate", 4, 2)->default(0.6);
            $table->decimal("tip_rate", 4,2)->default(0.6);
            $table->integer("number_of_payments")->default(1);
            $table->bigInteger("default_payment_type")->nullable();
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
        Schema::dropIfExists('technician_details');
    }
}
