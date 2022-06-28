<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id('promotion_id');
            $table->integer('promotion_type_id');
            $table->integer('restaurant_id');
            $table->string('promotion_code', 255);
            $table->string('promotion_name', 255);
            $table->longText('promotion_details')->nullable();
            $table->string('discount', 10);
            $table->string('discount_type', 255);
            $table->string('client_type', 255)->nullable();
            $table->string('order_type', 255)->nullable();
            $table->string('selected_payment_status', 255)->nullable();
            $table->string('mark_promoas_status', 255)->nullable();
            $table->string('display_time', 255)->nullable();
            $table->string('minimum_order_status', 255)->nullable();
            $table->string('no_extra_charge_type', 255)->nullable();
            $table->string('promotion_function', 255)->nullable();
            $table->string('availability', 255)->nullable();
            $table->string('promotion_status')->nullable();
            $table->string('promotion_used')->nullable();
            $table->string('status')->default('ACTIVE');
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
        Schema::dropIfExists('promotions');
    }
}
