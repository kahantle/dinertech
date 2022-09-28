<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('uid');
            $table->string('role')->default('CUSTOMER');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email_id')->unique();
            $table->string('mobile_number')->unique();
            $table->string('profile_image')->nullable();
            $table->string('fcm_id')->nullable();
            $table->enum('status', ['ACTIVE', 'INACTIVE'])->default('ACTIVE');
            $table->timestamp('is_verified_at')->nullable();
            $table->string('password');
            $table->string('otp')->nullable();
            $table->datetime('otp_valid_time')->nullable();
            $table->boolean('app_notifications');
            $table->boolean('chat_notifications');
            $table->boolean('location_tracking');
            $table->integer('subscription_id')->unsigned()->nullable()->default(12);
            // $table->boolean('loyalty_subscription')->nullable()->default(false);
            $table->enum('email_subscription', ['ACTIVE', 'INACTIVE'])->default('INACTIVE');
            $table->enum('loyalty_subscription', ['ACTIVE', 'INACTIVE'])->default('INACTIVE');
            $table->string('google_id')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
