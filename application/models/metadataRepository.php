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
			$resources->Arreglo que contiene las id´s de los metadatos relacionados al id del termino
	*/

	public function get_MetadataId($idTerm, $idColumn,$numConsult){		
		if ($idColumn == "ParentKey"){
			$metadatas = DB::table('metadata AS m')
						->join('europeanaterms AS e','e.id_europeana_term','=','m.id_europeana_term')
						->where("m.$idColumn",'=',$idTerm)->skip(200*$numConsult)->take(200)->get('id_metadata_term');

			return $metadatas;
		}
		else if($idColumn == "term_id"){
			$metadatas = DB::table('metadata AS m')
						->join('europeanaterms AS e','e.id_europeana_term','=','m.id_europeana_term')

						->where("e.$idColumn",'=',$idTerm)->skip(200*$numConsult)->take(200)->get('id_metadata_term');
			return $metadatas;
		}
	}

	/* Info
		<Desarrollado>
		Carlos Sáenz
		<Resumen>
		-Funcionalidad:
			Metodo encargado de guardar un nuevo metadatado dentro de la base dedatos
		-Variables:			
			$idEuTerm->Id que identifica el termino al cual se le esta asignando un nuevo recurso
			$parentKey->Id que identifica la llave del padre asociada a este termino
		-Retorno:
			$newMetadata-> Objeto de tipo Metadata, el cual es el nuevo recurso ingresado dentro de la base de datos
	*/
	public function insert_Metadata($idEuTerm, $parentKey){
		try{
			$newData = array("ParentKey"=>$parentKey);
			$europeanaTerm =  EuropeanaTerm::find($idEuTerm);
			$newMetadata = new Metadata($newData);
			$newMetadata = $europeanaTerm->metadata()->insert($newMetadata);
			return $newMetadata;
		}catch(Exception $e){
			return false;
		}		

	}
}