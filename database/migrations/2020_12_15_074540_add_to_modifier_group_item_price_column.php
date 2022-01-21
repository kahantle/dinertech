<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToModifierGroupItemPriceColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_menu_modifier_group_item', function (Blueprint $table) {
            $table->float('modifier_group_item_price',10,2)->after('modifier_group_item_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_menu_modifier_group_item', function (Blueprint $table) {
            //
        });
    }
}
