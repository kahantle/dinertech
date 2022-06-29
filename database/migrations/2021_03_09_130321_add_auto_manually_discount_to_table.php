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
            $table->string('auto_manually_discount',255)->nullable()->after('order_type');
            $table->string('discount_cheapest')->nullable()->after('auto_manually_discount');
            $table->string('discount_expensive')->nullable()->after('discount_cheapest');
            $table->string('item_group_1')->nullable()->after('discount_expensive');
            $table->string('item_group_2')->nullable()->after('item_group_1');
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
