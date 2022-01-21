<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_feedback', function (Blueprint $table) {
            $table->id();
            $table->integer('restaurant_id');
            $table->enum('feedback_type',['Feedback','Ideas','Features']);
            $table->enum('feedback_report',['Excellent','Good','Bad'])->nullable();
            $table->string('suggestion');
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
        Schema::dropIfExists('restaurant_feedback');
    }
}
