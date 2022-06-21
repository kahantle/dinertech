<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantLoyaltyRulesItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_loyalty_rules_items', function (Blueprint $table) {
            $table->id('rule_item_id');
            $table->integer('restaurant_id')->nullable();
            $table->integer('loyalty_rule_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('menu_id')->nullable();
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
        Schema::dropIfExists('restaurant_loyalty_rules_items');
    }
}
