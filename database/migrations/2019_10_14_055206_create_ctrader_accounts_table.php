<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCtraderAccountsTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ctrader_accounts');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ctrader_accounts', function (Blueprint $table) {
            $table->bigInteger('paymaster_id')->index()->comment('user_id of paymaster who owns this ctrader accounts');
            $table->bigInteger('accountId')->comment('Needed To Get Trading History');
            $table->index('accountId');
            $table->bigInteger('accountNumber');
            $table->boolean('live');
            $table->string('brokerName');
            $table->string('brokerTitle');
            $table->string('depositCurrency');
            $table->bigInteger('traderRegistrationTimestamp')->comment('timestamp in milliseconds');
            $table->string('traderAccountType');
            $table->integer('leverage');
            $table->integer('leverageInCents');
            $table->integer('balance')->comment('Balance in cents, divided by 100 to get whole number');
            $table->boolean('deleted');
            $table->string('AccountStatus');
            $table->boolean('swapFree');
        });
    }
}
