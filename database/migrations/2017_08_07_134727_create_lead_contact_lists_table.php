<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeadContactListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_contact_lists', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('lead_id')->unsigned();
			$table->foreign('lead_id')->references('id')->on('leads')->onDelete('cascade');
			$table->integer('contact_id')->unsigned();
			$table->foreign('contact_id')->references('id')->on('lead_contacts')->onDelete('cascade');
			$table->string('contact_value')->nullable();
			$table->string('contact_type');
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
        Schema::dropIfExists('lead_contact_lists');
    }
}
