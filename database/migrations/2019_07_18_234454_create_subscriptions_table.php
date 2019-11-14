<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('paymaster_id')->nullable();
            $table->foreign('paymaster_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name')->unique();
            $table->unsignedInteger('amount');
            // create an accessor to get cycle every
            // like we implemented on the UI
            $table->unsignedInteger('interval')->comment('interval is in unit of hr');
            $table->unsignedInteger('interval_count');
            $table->unsignedBigInteger('plan_id');
            $table->string('plan_type');
            $table->unsignedInteger('commission_id');
            $table->string('commission_type');
            $table->boolean('lifetime');
            $table->timestamps();
        });
    }
}
