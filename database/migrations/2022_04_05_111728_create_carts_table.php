<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id('cart_id');
            $table->integer('restaurant_id')->nullable();
            $table->integer('uid')->nullable();
            $table->integer('promotion_id')->nullable();
            $table->enum('is_payment',['Cash','Credit Card'])->nullable();
            $table->string('loyalty_points')->nullable();
            $table->string('sub_total')->default('0.00');
            $table->string('discount_charge')->default('0.00');
            $table->string('tax_charge')->default('0.00');
            $table->string('total_due')->default('0.00');
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
        Schema::dropIfExists('carts');
    }
}
