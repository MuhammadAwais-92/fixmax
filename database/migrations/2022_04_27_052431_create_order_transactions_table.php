<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('payer_id')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('payer_email')->nullable();
            $table->string('payer_status')->nullable();
            $table->longText('paypal_response')->nullable();
            $table->longText('charges')->nullable();
            $table->string('currency')->nullable();
            $table->longText('transaction_details')->nullable();
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
        Schema::dropIfExists('order_transactions');
    }
}
