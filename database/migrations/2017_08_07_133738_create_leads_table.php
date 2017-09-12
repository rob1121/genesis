<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeadsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create(
			'leads', function ( Blueprint $table ) {
			$table->increments( 'id' );
			$table->string( 'user_id' );
			$table->string( 'org_id' );
			$table->string( 'title' )->nullable();
			$table->string( 'url' )->nullable();
			$table->string( 'description' )->nullable();
			$table->string( 'address' )->nullable();
			$table->string( 'status' )->default('potential');
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
		Schema::dropIfExists( 'leads' );
	}
}
