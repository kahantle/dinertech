<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePromotionCategoryItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion_category_items', function (Blueprint $table) {
            $table->id('promotion_category_item_id');
            $table->integer('promotion_eligible_item_id');
            $table->integer('eligible_item_id');
            $table->integer('promotion_id');
            $table->integer('promotion_category_id');
            $table->integer('category_id');
            $table->integer('item_id');
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
        Schema::dropIfExists('promotion_category_items');
    }
}
