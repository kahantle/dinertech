<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerFcmTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_fcm_tokens', function (Blueprint $table) {
            $table->id('customer_fcmtoken_id');
            $table->integer('uid')->unsigned()->nullable();
            $table->string('fcm_id', 100)->nullable();
            $table->tinyInteger('device')->nullable()->comment('0 = Android, 1 = Ios');
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
        Schema::dropIfExists('customer_fcm_tokens');
    }
}
