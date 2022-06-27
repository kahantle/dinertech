<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_subscriptions', function (Blueprint $table) {
            $table->id('restaurant_subscription_id');
            $table->integer('restaurant_id')->nullable();
            $table->integer('uid')->nullable();
            $table->integer('subscription_id')->nullable();
            $table->string('stripe_subscription_id')->nullable();
            $table->string('stripe_payment_method')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->enum('status',['ACTIVE','INACTIVE','SCHEDULE']);
            $table->integer('restaurant_payment_id')->nullable();
            $table->enum('subscription_plan',['Restaurant Registration','Loyalty','Email Marketing']);
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
        Schema::dropIfExists('restaurant_subscriptions');
    }
}
