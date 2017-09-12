<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeadCustomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_customs', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('lead_id')->unsigned();
			$table->foreign('lead_id')->references('id')->on('leads')->onDelete('cascade');
			$table->string('custom_name');
			$table->string('custom_value');
			$table->string('custom_type');
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
        Schema::dropIfExists('lead_customs');
    }
}
