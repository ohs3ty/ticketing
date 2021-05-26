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
            $table->id();
            $table->string('preferredFirstName');
            $table->string('preferredSurname');
            $table->string('role');
            $table->string('patron_profile');
            $table->string('net_id');
            $table->string('byu_id')->nullable();
            $table->text('memberOf')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('has_paid');
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
