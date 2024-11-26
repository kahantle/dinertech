<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToOrderTableColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('is_tip')->nullable()->default(false)->after('pickup_minutes');
            $table->float('tip_amount')->nullable()->default(0.00)->after('is_tip');
            $table->tinyInteger('is_refund')->default(0)->after('tip_amount');
            $table->tinyInteger('is_partial_refund')->default(0)->after('is_refund');
            $table->string('refund_amount', 255)->default(0)->after('is_partial_refund');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
