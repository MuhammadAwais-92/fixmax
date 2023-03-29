<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->double('price',18,2);
            $table->unsignedBigInteger('equipment_id');
            $table->longText('name');
            $table->string('equipment_model')->nullable();
            $table->string('make')->nullable();
            $table->longText('image')->nullable();
            $table->integer('quantity')->nullable()->default(0);
            $table->double('total',18,2);
            $table->integer('created_at')->nullable();
            $table->integer('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
