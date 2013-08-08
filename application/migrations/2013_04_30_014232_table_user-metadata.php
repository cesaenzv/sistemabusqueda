<?php

class Table_User_Metadata {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user', function($table) {
			$table->engine = 'InnoDB';
		    $table->increments('id');
		    $table->string('username', 128);
		    $table->string('password', 64);
		});

		Schema::create('metadata', function($table) {
			$table->engine = 'InnoDB';
		    $table->increments('id_metadata_Term');
		    $table->integer('ParentKey');
		    $table->integer('id_europeana_term');

		    $table->foreign('id_europeana_term')->references('id_europeana_term')->on('europeanaterms')->on_delete('cascade');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('metadata',function(){
			$table->drop_foreign('metadata_id_europeana_term_foreign');
		});
		Schema::drop('user');
	}

}