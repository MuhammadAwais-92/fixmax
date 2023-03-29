<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id');
            $table->longText('name');
            $table->longText('description');
            $table->tinyInteger('is_active')->default(1)->nullable();
            $table->double('discount',5,2)->default(0.00);
            $table->unsignedInteger('expiry_date')->nullable();
            $table->double('average_rating',5,2)->default(0.00)->nullable();
            $table->unsignedInteger('created_at')->nullable();
            $table->unsignedInteger('updated_at')->nullable();
            $table->unsignedInteger('deleted_at')->nullable();
            $table->double('min_price',18,2)->nullable();
            $table->double('max_price',18,2)->nullable();
            $table->string('service_type')->nullable();
      


            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
