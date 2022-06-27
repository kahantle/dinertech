<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToRestaurantPaymentTableColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('restaurant_payment', function (Blueprint $table) {
            $table->integer('subscription_id')->unsigned()->nullable()->after('restaurant_id');
            $table->string('stripe_subscription_id', 255)->nullable()->after('subscription_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('restaurant_payment', function (Blueprint $table) {
            //
        });
    }
}
