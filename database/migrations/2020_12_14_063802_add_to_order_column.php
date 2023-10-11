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
            $table->string('stripe_charge_id', 255)->nullable()->after('stripe_payment_id');
            $table->string('payment_method_id', 255)->nullable()->after('stripe_charge_id');
            $table->string('payment_intent_id', 255)->nullable()->after('payment_method_id');
            $table->string('payment_intent_client_secret', 255)->nullable()->after('payment_intent_id');
            $table->string('stripe_refund_id', 255)->nullable()->after('payment_intent_client_secret');
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
