<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('paymaster_id')->nullable();
            $table->foreign('paymaster_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('member_id')->nullable();
            $table->foreign('member_id')->references('id')->on('users')->onDelete('cascade');

            $table->date('date_enter')->default(now());
            $table->date('date_activated')->nullable();
            $table->boolean('activated')->default(false);

            $table->double('amount', 12, 2)->nullable()->default(0);

            $table->unsignedBigInteger('gateway_id')->nullable();
            $table->foreign('gateway_id')->references('id')->on('gateways')->onDelete('cascade');

            $table->json('gateway_details')->nullable();

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
        Schema::dropIfExists('payments');
    }
}
