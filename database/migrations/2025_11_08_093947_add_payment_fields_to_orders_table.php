<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->after('total');
            $table->string('payment_status')->default('unpaid')->after('payment_method');
            $table->string('transaction_id')->nullable()->after('payment_status');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_method','payment_status','transaction_id']);
        });
    }
};
