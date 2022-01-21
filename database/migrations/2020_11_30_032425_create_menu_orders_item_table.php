<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuOrdersItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_menu_modifier_group', function (Blueprint $table) {
            $table->id('order_modifier_group_id');
            $table->integer('order_id');
            $table->integer('order_menu_item_id');
            $table->integer('menu_id');
            $table->integer('modifier_group_id');
            $table->string('modifier_group_name');
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
