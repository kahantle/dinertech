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
        Schema::create('refund_history', function (Blueprint $table) {
            $table->bigIncrements('refund_history_id');
            $table->unsignedInteger('restaurant_id')->default(0);
            $table->unsignedInteger('order_id')->default(0);
            $table->string('stripe_refund_id', 255)->nullable();
            $table->tinyInteger('is_partial_refund')->default(0)->comment('0 => full refund, 1 => partial refund');
            $table->string('stripe_refund_amount', 255)->nullable();
            $table->string('refund_amount', 255)->nullable();
            $table->text('refund_details_object')->nullable();
            $table->text('refund_object')->nullable();
            $table->enum('is_active', ['1', '0'])->default('1')->comment('0 => Inactive, 1 => Active');
            $table->enum('is_delete', ['0', '1'])->default('0')->comment('0 => Not Deleted, 1 => Deleted');
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
