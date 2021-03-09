<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('event_name');
            $table->text('event_description')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('venue_id')->unsigned();
            $table->integer('event_type_id')->unsigned();
            $table->integer('organization_id')->unsigned();
            $table->foreign('venue_id')->references('id')->on('venues');
            $table->foreign('event_type_id')->references('id')->on('event_types');
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
        Schema::dropIfExists('events');
    }
}
