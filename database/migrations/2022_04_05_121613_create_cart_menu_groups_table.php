<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartMenuGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_menu_groups', function (Blueprint $table) {
            $table->id('cart_modifier_group_id');
            $table->integer('cart_id')->nullable();
            $table->integer('cart_menu_item_id')->nullable();
            $table->integer('menu_id')->nullable();
            $table->integer('modifier_group_id')->nullable();
            $table->string('modifier_group_name')->nullable();
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
        Schema::dropIfExists('cart_menu_groups');
    }
}
