<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name')->nullable();
            $table->string('coupon_code')->nullable();
            $table->integer('discount')->default(0);
            $table->integer('end_date')->nullable();
            $table->enum('coupon_type', ['infinite', 'number'])->default("number");
            $table->enum('status', ['active', 'expire', 'finish'])->default("active");
            $table->integer('coupon_number')->nullable()->default(0);
            $table->integer('reserved')->nullable()->default(0);
            $table->integer('used')->nullable()->default(0);
            $table->integer('created_at')->nullable();
            $table->integer('updated_at')->nullable();
            $table->integer('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
