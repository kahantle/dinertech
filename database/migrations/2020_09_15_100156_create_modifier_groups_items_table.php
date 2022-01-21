<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModifierGroupsItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modifier_groups_items', function (Blueprint $table) {
            $table->id('modifier_item_id');
            $table->integer('restaurant_id');
            $table->string('modifier_group_id');
            $table->string('modifier_group_item_name');
            $table->double('modifier_group_item_price', [10, 2]);
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
        Schema::dropIfExists('modifierGroupsItems');
    }
}
