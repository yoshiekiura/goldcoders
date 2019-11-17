<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionFixValueTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription_fix_value');

    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_fix_value', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('paymaster_id')->nullable(); // use as referrence for paymaster
            $table->string('name')->unique();
            $table->unsignedInteger('min')->comment('min amount allowed to enter this plan');
            $table->unsignedInteger('max')->commment('maximum amount allowed to enter this plan');
            $table->double('roi')->comment('expected amount to be earned at end of duration of plan'); // total ROI
            $table->unsignedInteger('value')->comment('fix value earned per interval');
            $table->unsignedInteger('interval')->comment('time interval in unit of hr to distribute earned amount in a plan');
            $table->unsignedInteger('duration')->comment('total duration of plan in unit of time in hr'); // 0 means forever, duration in units of hrs
            $table->boolean('active')->default(0)->comment('Admin will activate this type of plan manually');
            $table->timestamps();
        });
    }
}
