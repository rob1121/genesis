<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeadTasksTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create(
			'lead_tasks', function ( Blueprint $table ) {
			$table->increments( 'id' );
			$table->integer( 'lead_id' )->unsigned();
			$table->foreign( 'lead_id' )->references( 'id' )->on( 'leads' )->onDelete( 'cascade' );
			$table->integer( 'user_id' )->unsigned();
			$table->foreign( 'user_id' )->references( 'id' )->on( 'users' );
			$table->text( 'message' )->nullable();
			$table->date( 'date' )->format('mm/dd/YY');
			$table->time( 'time' )->nullable();
			$table->string( 'status' )->nullable();
			$table->timestamps();
		}
		);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'lead_tasks' );
	}
}
