<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionPercentageTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription_percentage');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_percentage', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('paymaster_id')->nullable(); // use as referrence for paymaster
            $table->string('name')->unique();
            $table->unsignedInteger('min')->comment('min amount allowed to enter this plan');
            $table->unsignedInteger('max')->commment('maximum amount allowed to enter this plan');
            $table->double('roi')->comment('expected total percentage earn after the duration'); // total ROI
            $table->unsignedInteger('percent')->comment('fix percent earned per interval');
            $table->unsignedInteger('interval')->comment('time interval in unit of hr to distribute earned amount in a plan');
            $table->unsignedInteger('duration')->comment('total duration of plan in unit of time in hr'); // 0 means forever, duration in units of hrs
            $table->boolean('active')->default(0)->comment('Admin will activate this type of plan manually');
            $table->timestamps();
        });
    }
}
