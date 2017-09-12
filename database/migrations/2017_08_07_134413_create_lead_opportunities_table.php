<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeadOpportunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_opportunities', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('user_id')->unsigned()->nullable();
			$table->integer('contact_id')->unsigned()->nullable();
			$table->integer('lead_id')->unsigned();
			$table->foreign('lead_id')->references('id')->on('leads')->onDelete('cascade');
			$table->string('status')->nullable();
			$table->string('confidence')->nullable();
			$table->string('value')->nullable();
			$table->string('value_period')->nullable();
			$table->date('close_date')->nullable()->format('mm/dd/YY');
			$table->text('comments')->nullable();
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
        Schema::dropIfExists('lead_opportunities');
    }
}
