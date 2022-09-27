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
            $table->id('order_id');
            $table->integer('uid');
            $table->integer('restaurant_id');
            $table->integer('payment_card_id');
            $table->string('stripe_payment_id');
            $table->string('order_number');
            $table->date('order_date')->nullable();
            $table->time('order_time')->nullable();
            $table->integer('address_id');
            $table->boolean('isPickUp')->default(0);
            $table->string('cart_charge')->default(0);
            $table->string('delivery_charge')->default(0);
            $table->string('discount_charge')->default(0);
            $table->string('sales_tax')->default(0);
            $table->date('feature_date')->nullable();
            $table->time('feature_time')->nullable();
            $table->boolean('is_feature')->default(0);
            $table->string('pickup_time')->nullable();
            $table->longText('comments');
            $table->string('grand_total');
            $table->boolean('order_status')->nullable();
            $table->string('order_progress_status')->default('INITIAL');
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
        Schema::dropIfExists('orders');
    }
}
