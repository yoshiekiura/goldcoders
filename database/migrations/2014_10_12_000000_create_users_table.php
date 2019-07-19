<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sp_id')->nullable();
            $table->string('username')->unique(); // generate ramdom username
            $table->string('email')->unique()->nullable();
            $table->string('password', 60);
            $table->unsignedTinyInteger('resent')->default(0);
            $table->boolean('active')->default(0);
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->string('mname')->nullable();
            $table->text('avatar')->nullable();
            $table->date('dob')->nullable();                  // dd/mm/yyyy
            $table->string('suffix')->nullable(); //SR. Jr
            $table->string('mobile_no')->nullable();
            $table->string('current_address')->nullable();
            $table->string('permanent_address')->nullable();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
        });
    }
}
