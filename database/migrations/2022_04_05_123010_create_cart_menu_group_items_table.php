<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartMenuGroupItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_menu_group_items', function (Blueprint $table) {
            $table->id('cart_modifier_menu_id');
            $table->integer('cart_id')->nullable();
            $table->integer('cart_menu_item_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('menu_id')->nullable();
            $table->integer('cart_modifier_group_id')->nullable();
            $table->integer('modifier_item_id')->nullable();
            $table->integer('modifier_group_id')->nullable();
            $table->string('modifier_group_item_name')->nullable();
            $table->string('modifier_group_item_price')->nullable();
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
        Schema::dropIfExists('cart_menu_group_items');
    }
}
