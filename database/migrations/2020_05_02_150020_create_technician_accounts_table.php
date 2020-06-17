<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechnicianAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technician_accounts',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('technician_id')->unsigned();
                $table->foreign('technician_id')->references('id')
                    ->on('technicians')->onUpdate('cascade')->onDelete('cascade');
                $table->bigInteger('account_type_id')->unsigned();
                $table->foreign('account_type_id')->references('id')
                    ->on('account_types')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
                $table->string('name');

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
        Schema::dropIfExists('accounts');
    }
}
