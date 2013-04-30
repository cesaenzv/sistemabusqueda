<?php 

class MandatoryRepository {

	/* Info
		<Desarrollado>
		Carlos Sáenz
		<Resumen>
		-Funcionalidad:
			Metodo encargado de obtener toda la informacion mandatoria de un conjunto de metadatos, teniendo como depuradores en la 
			busqueda un criterio y un subgrupo o valor especifico de tal criterio
		-Variables:
			$metadatasId->Id´s de todos los metadatos relacionados al termino buscado
			$criterio->Criterio que realiza la agrupacion de los metada
			$group->Sub grupo del criterio por el cual se esta consultado los recursos			
		-Retorno:
			$resources->Arreglo que contiene la informacion de los recursos recuperados
	*/
	public function getMandatoryResourceList($metadatasId,$criterio,$group){
		$resources = array();
		foreach ($metadatasId as $metadataId) {
			$result = Mandatory::where_id_metadata_mandatory($metadataId->id_metadata_term)
				->where($criterio,'=',$group)->first(array('id_metadata_mandatory','EuropeanaURL','Title','Description','Subject','Type'));	
			if ($result){				
				$resource = $result->to_array();										
				$resources[] = $resource;
			}
		}						
		return  $resources;
	}

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
		$fields = DB::table('metadataMandatory')->columns('id_metadata_mandatory');
		return $fields;
	}

	/* Info
		<Desarrollado>
		Carlos Sáenz
		<Resumen>
		-Funcionalidad:
			Metodo encargado de guardar un nuevo objeto mandatory dentro de la base dedatos relacionado a un metadata
		-Variables:			
			
		-Retorno:
			$newMetadata-> Objeto de tipo Metadata, el cual es el nuevo recurso ingresado dentro de la base de datos
	*/
	public function insert_Mandatory($idMetadata,$europeanaUrl,$title,$description,$language,
									$dataProvider,$isShownAt, $isShownBy,$provider,$subject,$type,
									$coverage, $spatial, $rights, $country){
		try{
			$newData = array( "EuropeanaURL"=>$europeanaUrl, "Title"=>$title, "Description"=>$description,
						  "Language"=>$language, "DataProvider"=>$dataProvider,	"IsShownAt"=>$isShownAt,
						  "IShownBy"=>$isShownBy, "Provider"=>$provider, "Subject"=>$subject, "Type"=>$type,
						  "Coverage"=>$coverage, "Spatial"=>$spatial, "Rights"=>$rights, "Country"=>$country);
			$metadata = Metadata::find($idMetadata);
			$newMandatory = new Mandatory($newData);
			$newMandatory = $metadata->mandatory->insert($newMandatory);
			return $newMandatory;
		}catch(Exception $e){
			return false;
		}		
	}
}