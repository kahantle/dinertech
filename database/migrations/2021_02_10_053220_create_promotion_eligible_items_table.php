<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionEligibleItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion_eligible_items', function (Blueprint $table) {
            $table->id('promotion_eligible_item_id');
            $table->integer('promotion_id')->nullable();
            $table->integer('eligible_item_id')->nullable();
            $table->string('item_group_discount',10)->nullable();
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
        Schema::dropIfExists('promotion_eligible_items');
    }
}
