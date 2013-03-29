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
	public function get_MetadataId($idTerm, $idColumn){		
		if ($idColumn == "ParentKey"){
			$metadatas = DB::table('metadata AS m')
						->join('europeanaterms AS e','e.id_europeana_term','=','m.id_europeana_term')
						->where("m.$idColumn",'=',$idTerm)->get('id_metadata_term');
			return $metadatas;
		}
		else if($idColumn == "term_id"){
			$metadatas = DB::table('metadata AS m')
						->join('europeanaterms AS e','e.id_europeana_term','=','m.id_europeana_term')
						->where("e.$idColumn",'=',$idTerm)->get('id_metadata_term');
			return $metadatas;
		}
	}
}