<?php 

class MetadataRepository {

	/* Info
		<Desarrollado>
		Carlos Sáenz
		<Resumen>
		-Funcionalidad:
			Metodo encargado de obtener el id_metadata_term con respecto al id_europena_term
		-Variables:			
			$idTerm->Id que identifica el termino por el cual se realiza la consulta de los pies, conocido en la BD
			como term_id en la tabla de europena terms
		-Retorno:
			$resources->Arreglo que contiene las id´s de los metadatos relacionados al id del termino termino
	*/
	public function get_MetadataId($idTerm){		
		$metadatas = DB::table('metadata128 AS m')
						->join('eurpeanaterms128 AS e','e.id_europena_term','m.id_europena_term')
						->where('e.term_id','=',$idTerm)->get('id_metadata_term');
		return $metadatas;
	}
}