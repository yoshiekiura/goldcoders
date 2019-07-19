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
            $table->string('plan');    // plan[1-6] rank[executive, bronze, silver, gold ,diamond , elite]
            $table->string('rank');    // executive, bronze, silver, gold ,diamond , elite
            $table->integer('amount'); //10500,21000 etc
            $table->text('payment_gateway')->nullable();
            $table->text('image_url')->nullable();
            $table->date('date_activated')->nullable(); // dd/mm/yyyy
            $table->date('date_paid')->nullable();      // same as date_deposited
            $table->boolean('locked_in')->default(0);
            $table->timestamps();
        });
    }
}
