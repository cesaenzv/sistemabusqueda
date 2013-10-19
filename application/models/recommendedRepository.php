<?php 

class RecommendedRepository{

	/* Info
		<Desarrollado>
		Carlos Sáenz
		<Resumen>
		-Funcionalidad:
			Metodo encargado de obtener de cada modelo en nombre y el tipo de dato de cada uno de los campos correspodientes
			dentro de la base de datos				
		-Retorno:
			$fields->Arreglo que contiene la informacion de los atributos de la base de datos
	*/
	public function getFormFields(){
		$fields = DB::table('metadataRecommended')->columns('id_metadata_recommended','aatnormalizada');
		return $fields;
	}

	/* Info
		<Desarrollado>
		Carlos Sáenz
		<Resumen>
		-Funcionalidad:
			Metdo encargado de realizar la insercion de un nuevo objeto dentro de la base de datos				
		-Retorno:
			$newRecommended->Nuevo recurso creado
	*/
	public function insert_Recommended ($idMetadata,$alternative,$creator,$contributor,$date,$created,$issued,
										$temporal,$publisher,$source,$isPartOf){
		try{
			$newData = array("Alternative"=>$alternative, "Creator"=>$creator, "Contributor"=>$contributor,	
							 "Date"=>$date,"Created"=>$created,"Issued"=>$issued,"Temporal"=>$temporal,
							 "Publisher"=>$publisher,"Source"=>$source,"IsPartOf"=>$isPartOf);
			$metadata = Metadata::find($idMetadata);
			$newRecommended = new Recommended($newData);
			$newRecommended = $metadata->recommended->insert($newRecommended);
			return $newRecommended;
		}catch(Exception $e){
			return false;
		}
	}

}