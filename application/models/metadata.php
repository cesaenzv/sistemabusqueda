<?php


class Metadata extends Eloquent {

	public static $timestamps = false;

	public static $table = 'metadata128';

	public static $key = 'id_metadata_term';

	public function europeanaTerm(){

		return $this->belongs_to('EuropeanaTerm','id_europeana_term');
		
	}

}