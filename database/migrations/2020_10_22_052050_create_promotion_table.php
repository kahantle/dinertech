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
            $table->string('promotion_code');
            $table->string('promotion_name');
            $table->longText('promotion_details');
            $table->string('discount');
            $table->string('discount_type');
            $table->string('client_type')->nullable();
            $table->string('order_type')->nullable();
            $table->string('selected_payment_status')->nullable();
            $table->string('mark_promoas_status')->nullable();
            $table->string('display_time')->nullable();
            $table->string('minimum_order_status')->nullable();
            $table->string('no_extra_charge_type')->nullable();
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
