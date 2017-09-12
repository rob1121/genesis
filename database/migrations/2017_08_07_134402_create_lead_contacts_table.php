<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeadContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_contacts', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('lead_id')->unsigned();
			$table->foreign('lead_id')->references('id')->on('leads')->onDelete('cascade');
			$table->string('contact_name')->nullable();
			$table->string('contact_title')->nullable();
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
        Schema::dropIfExists('lead_contacts');
    }
}
