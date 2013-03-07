<?php

class EuropeanaTermRepository{

	/* Info
		<Desarrollado>
		Carlos Sáenz
		<Resumen>
		-Funcionalidad:
			Metodo encargado de obtener el id_erupena_term, por medio del nombre del termino siendo este en la BD el campo 
			"termNameUtf8"
		-Variables:
			$term->Varible que se recibe la cual contiene el nombre del termino a buscar
		-Retorno:
			$Id->Id del termino buscado 
	*/
	public function get_IdByTerm($term){
		$Id = EuropeanaTerm::where_termNameUtf8($term)->first()->id_europeana_term;
		return $Id;
	}

	public function get_Term_idByTerm($term){
		$Id = EuropeanaTerm::where_termNameUtf8($term)->first()->id_europeana_term;
		return array('id'=>$Id);
	}

	/* Info
		<Desarrollado>
		Carlos Sáenz
		<Resumen>
		-Funcionalidad:
			Metodo encargado de retornar una lista de todos los terminos encontrados en la BD
		-Retorno:
			$terms->Arreglo de nombre de los terminos
	*/
	public function get_TermList(){
		$terms = DB::table('europeanaterms')->get('termNameUtf8');
		return $terms;
	}

}