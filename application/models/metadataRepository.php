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

	public function get_MetadataId($idTerm, $columnType,$numConsult = 0, $criterio, $group){		
		if ($columnType == "ParentKey"){			
			$metadatasId = DB::table('metadata AS m')
						->join('europeanaterms AS e','e.id_europeana_term','=','m.id_europeana_term')
						->join('metadatamandatory AS mm','m.id_metadata_term','=','mm.id_metadata_mandatory')
						->where("m.$columnType",'=',$idTerm)->where("mm.$criterio","=",$group)->order_by("mm.id_metadata_mandatory")
						->skip(200*$numConsult)->take(200)->get('id_metadata_term');
			return $metadatasId;
			
		}
		else if($columnType == "term_id"){
			$metadatasId = DB::table('metadata AS m')
						->join('europeanaterms AS e','e.id_europeana_term','=','m.id_europeana_term')
						->join('metadatamandatory AS mm','m.id_metadata_term','=','mm.id_metadata_mandatory')
						->where("e.$columnType",'=',$idTerm)->where("mm.$criterio","=",$group)->order_by("mm.id_metadata_mandatory")
						->skip(200*$numConsult)->take(200)->get('id_metadata_term');
			return $metadatasId;
			
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