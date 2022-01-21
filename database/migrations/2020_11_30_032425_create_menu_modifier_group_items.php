<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuModifierGroupItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_menu_item', function (Blueprint $table) {
            $table->id('order_menu_item_id');
            $table->integer('order_id');
            $table->integer('menu_id');
            $table->string('menu_name');
            $table->integer('menu_qty');
            $table->string('modifier_total');
            $table->string('menu_total');
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
        Schema::dropIfExists('order_menu_item');
    }
}
