<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToRestaurantFeedbackFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('restaurant_feedback', function (Blueprint $table) {
            $table->string('email')->nullable()->after('restaurant_id');
            $table->string('phone')->nullable()->after('restaurant_id');
            $table->string('name')->nullable()->after('restaurant_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('restaurant_feedback', function (Blueprint $table) {
            //
        });
    }
}
