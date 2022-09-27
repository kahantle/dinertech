<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use cf as cf;

class AddToOrderColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('action_time')->nullable();
            $table->enum('point_count', ['YES', 'NO'])->nullable()->default('NO');
            $table->enum('isCash', [cf::get('constants.ORDER_PAYMENT_TYPE.CARD_PAYMENT'), cf::get('constants.ORDER_PAYMENT_TYPE.CASH_PAYMENT')])->nullable()->after('isPickUp');
            $table->string('tax_charge', 255)->nullable()->default(0)->after('discount_charge');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
