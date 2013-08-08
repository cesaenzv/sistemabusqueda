<?php


class Metadata extends Eloquent {

	public static $timestamps = false;

	public static $table = 'metadata';

	public static $key = 'id_metadata_term';

	public function europeanaTerm(){
		return $this->belongs_to('EuropeanaTerm','id_europeana_term');		
	}

	public function mandatory(){
		return $this->has_one('Mandatory','id_metadata_mandatory');
	}

	public function recomended(){
		return $this->has_one('Recommended','id_metadata_recommended');
	}

	public function optional(){
		return $this->has_one('Optional','id_metadata_optional');
	}

	public function ranking (){
		return $this->has_many('Ranking','id_metadata_term');
	}
}