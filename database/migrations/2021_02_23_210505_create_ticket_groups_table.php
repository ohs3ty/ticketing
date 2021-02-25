<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_groups', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('ticket_name');
            $table->float('ticket_cost');
            $table->text('ticket_description')->nullable();
            $table->integer('event_id')->unisgned();
            $table->integer('ticket_type_id')->unsigned();
            $table->date('ticket_open_date')->nullable();
            $table->date('ticket_close_date')->nullable();
            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('ticket_type_id')->references('id')->on('ticket_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_groups');
    }
}
