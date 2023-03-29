<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraws', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->double('amount')->default(0.0);
            $table->enum('status', ['pending', 'complete', 'rejected'])->default('pending');
            $table->enum('method', ['paypal', 'cash', 'other'])->default('paypal');
            $table->longText('paypal_response')->nullable();
            $table->longText('additional_details')->nullable();
            $table->longText('remarks')->nullable();
            $table->longText('image')->nullable();
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
        Schema::dropIfExists('withdraws');
    }
}
