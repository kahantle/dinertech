<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantLoyalitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_loyalties', function (Blueprint $table) {
            $table->id('loyalty_id'); 
            $table->integer('restaurant_id')->nullable();
            $table->integer('uid')->nullable();
            $table->string('loyalty_type')->nullable();
            $table->string('no_of_orders')->nullable();
            $table->string('amount')->nullable();
            $table->string('point')->nullable();
            $table->enum('status',['ACTIVE','INACTIVE'])->default('INACTIVE');
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
        Schema::dropIfExists('restaurant_loyalties');
    }
}
