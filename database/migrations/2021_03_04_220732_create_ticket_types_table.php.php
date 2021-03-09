<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_types', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('ticket_name');
            $table->float('ticket_cost');
            $table->integer('ticket_limit')->nullable();
            $table->text('ticket_description')->nullable();
            $table->integer('event_id')->unisgned();
            $table->integer('patron_profile_id')->unsigned();
            $table->date('ticket_open_date')->nullable();
            $table->date('ticket_close_date')->nullable();
            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('patron_profile_id')->references('id')->on('patron_profiles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_types');
    }
}
