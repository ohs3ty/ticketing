<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationOrganizersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_organizers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('organization_id')->unsigned();
            $table->integer('organizer_id')->unsigned();
            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->foreign('organizer_id')->references('id')->on('organizers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organization_organizers');
    }
}
