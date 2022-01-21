<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id('restaurant_id');
            $table->integer('uid');
            $table->string('restaurant_name')->unique();
            $table->string('restaurant_email')->nullable();
            $table->string('restaurant_mobile_number')->nullable();
            $table->longText('restaurant_address')->nullable();
            $table->string('restaurant_city')->nullable();
            $table->string('restaurant_state')->nullable();
            $table->string('restaurant_zip')->nullable();
            $table->decimal('restaurant_lat', 10, 8)->nullable();
            $table->decimal('restaurant_long', 10, 8)->nullable();
            $table->tinyInteger('is_pinprotected')->default(0);
            $table->tinyInteger('notification_status')->default(0);
            $table->tinyInteger('online_order_status')->default(0);
            $table->timestamp('is_verified_at')->nullable();
            $table->enum('status', ['ACTIVE', 'INACTIVE'])->default('ACTIVE');
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
        Schema::dropIfExists('restaurants');
    }
}
