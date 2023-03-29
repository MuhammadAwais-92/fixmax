<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('supplier_id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('full_name')->nullable();
            $table->string('order_number')->nullable();
            $table->longText('service_name')->nullable();
            $table->longText('address')->nullable();
            $table->longText('order_notes')->nullable();
            $table->enum('status', ['pending', 'visited', 'quoted','cancelled','rejected','confirmed','in-progress','completed']);
            $table->longText('image')->nullable();
            $table->longText('invoice')->nullable();
            $table->longText('quotation_invoice')->nullable();
            $table->longText('issue_images')->nullable();
            $table->double('min_price',18,2)->nullable();
            $table->double('max_price',18,2)->nullable();
            $table->double('visit_fee', 18, 2)->nullable()->default(0);
            $table->unsignedInteger('date')->nullable();
            $table->string('time')->nullable();
            $table->double('quoated_price',18,2)->nullable();
            $table->double('subtotal',18,2)->nullable();
            $table->double('platform_commission',18,2)->nullable()->default(0.00);
            $table->double('total_amount',18,2)->nullable();
            $table->double('discount',20,2)->nullable();
            $table->double('vat_1',18,2)->nullable();
            $table->double('vat_2',18,2)->nullable();
            $table->double('vat_percentage_1',18,2)->nullable();
            $table->double('vat_percentage_2',18,2)->nullable(); 
            $table->double('amount_paid',18,2)->nullable(); 
            $table->tinyInteger('is_visited')->default(0)->nullable();
            $table->tinyInteger('is_quoated')->default(0)->nullable();
            $table->string('issue_type')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
