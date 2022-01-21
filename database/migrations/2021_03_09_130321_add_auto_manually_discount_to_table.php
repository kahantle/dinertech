<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAutoManuallyDiscountToTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->integer('auto_manually_discount')->nullable()->after('order_type');
            $table->string('discount_cheapest')->nullable()->after('order_type');
            $table->string('discount_expensive')->nullable()->after('order_type');
            $table->string('item_group_1')->nullable()->after('order_type');
            $table->string('item_group_2')->nullable()->after('order_type');
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
