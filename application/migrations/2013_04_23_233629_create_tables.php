<?php

class Create_Tables {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($table) {
		    $table->increments('id');
		    $table->string('username', 128);
		    $table->string('password', 64);
		});

		Schema::create('metadata', function($table) {
		    $table->increments('id_metadata_term');
		    $table->integer('ParentKey');
		    $table->integer('id_europena_term')->unsigned();

		    $table->foreign('id_europena_term')->references('id_europena_term')->on('europeanaterms')->on_delete('cascade');
			$table->foreign('id_europena_term')->references('id_europena_term')->on('europeanaterms')->on_update('cascade');
		});
		
		Schema::create('ranking',function($table){
			$table->increments('idRanking');
			$table->integer('idUser')->unsigned();
			$table->integer('id_metadata_term');
			$table->integer('qualification');

			
			$table->foreign('idUser')->references('id')->on('users')->on_delete('cascade');
			$table->foreign('idUser')->references('id')->on('users')->on_update('cascade');

			$table->foreign('id_metadata_term')->references('id_metadata_term')->on('metadata')->on_delete('cascade');
			$table->foreign('id_metadata_term')->references('id_metadata_term')->on('metadata')->on_update('cascade');
		});

	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{	
		Schema::drop('metadata');
		Schema::drop('users');
		Schema::drop('ranking');
	}

}