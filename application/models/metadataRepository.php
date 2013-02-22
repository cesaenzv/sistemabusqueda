<?php 

class MetadataRepository {

	/* Info
		<Desarrollado>
		Carlos Sáenz
		<Resumen>
		-Funcionalidad:
			Metodo encargado de obtener el id_metadata_term con respecto al id_europena_term
		-Variables:			
			$idTerm->Id que identifica el termino por el cual se realiza la consulta de los pies
		-Retorno:
			$resources->Arreglo que contiene las id´s de los metadatos relacionados al id del termino termino
	*/
	public function get_MetadataId($idTerm){		
		$metadatas = DB::table('metadata128')->where_id_europeana_term($idTerm)->get('id_metadata_term');
		return $metadatas;
	}
}