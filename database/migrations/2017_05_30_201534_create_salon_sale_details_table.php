<?php


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateSalonSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salon_sale_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('salon_sale_id')->unsigned();
            $table->string('item')->default('none');
            $table->decimal('gross_sales',7,2)->default(0.0);
            $table->integer('items_sold')->default(0);
            $table->timestamps();

            $table->foreign('salon_sale_id')->references('id')->on('salon_sales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salon_sale_details');
    }
}
