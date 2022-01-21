<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id('card_id');
            $table->integer('uid');
            $table->integer('restaurant_id');
            $table->string('card_holder_name');
            $table->string('card_number');
            $table->string('card_expire_date');
            $table->string('card_cvv');
            $table->string('card_type');
            $table->string('status')->default('ENABLE');
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
        Schema::dropIfExists('cards');
    }
}
