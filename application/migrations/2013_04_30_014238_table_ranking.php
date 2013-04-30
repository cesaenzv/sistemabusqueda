<?php

class Table_Ranking {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ranking',function($table){
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->integer('qualification');			
			$table->integer('idUser')->unsigned();			
			$table->integer('id_metadata_term')->unsigned();						
			
			$table->foreign('id_metadata_term')->references('id_metadata_Term')->on('metadata')->on_delete('cascade');
			$table->foreign('idUser')->references('idUser')->on('user')->on_delete('cascade');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ranking',function(){
			$table->drop_foreign('user_idUser_foreign');
			$table->drop_foreign('user_id_metadata_term_foreign');
		});
	}

}