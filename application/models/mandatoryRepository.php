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
				->where($criterio,'=',$group)->first(array('resultName AS Link','Title','Description','Subject','Type'));	
			if ($result){
				$resources[] =$result->to_array();
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
}