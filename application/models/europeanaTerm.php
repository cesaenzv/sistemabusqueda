<?php

class EuropeanaTerm extends Eloquent {

	public static $timestamps = false;

	public static $table = 'europeanaterms';

	public static $key = 'id_europeana_term'; 

	public function metadata(){
		return $this->has_many('Metadata','id_europeana_term');		
	}
}

