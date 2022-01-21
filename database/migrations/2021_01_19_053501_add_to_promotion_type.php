<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToPromotionType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->string('dicount_usd_percentage')->nullable();
            $table->string('dicount_usd_percentage_amount')->nullable();
            $table->boolean('set_minimum_order')->nullable();
            $table->string('set_minimum_order_amount')->nullable();
            $table->boolean('only_selected_payment_method')->nullable();
            $table->string('only_selected_cash')->nullable();
            $table->string('only_selected_cash_delivery_person')->nullable();
            $table->boolean('only_once_per_client')->nullable();
            $table->string('mark_promo_as')->nullable();
            $table->string('eligible_items')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promotions', function (Blueprint $table) {
            //
        });
    }
}
