<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('organizer_email')->nullable();
            $table->string('organizer_phone');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('organization_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('organization_id')->references('id')->on('organizations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizers');
    }
}
