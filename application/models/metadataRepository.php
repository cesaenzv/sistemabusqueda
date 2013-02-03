<?php 

class MetadataRepository {

	/* Info
		<Desarrollado>
		Carlos Sáenz
		<Resumen>
		-Funcionalidad:
			Metodo encargado de obtener los recursos asociados a un termino con respecto a un termino, dado un criterio y un subgrupo
			de este criterio
		-Variables:
			$criterio->Criterio que realiza la agrupacion de los metada
			$group->Sub grupo del criterio por el cual se esta consultado los recursos
			$idTerm->Id que identifica el termino por el cual se realiza la consulta de los pies
		-Retorno:
			$resources->Arreglo que contiene la informacion de los recursos recuperados
	*/
	public function getMetadataResourceList($criterio,$group,$idTerm){
		$resources = DB::table('metadata128')->where('id_europeana_term','=',$idTerm)->
							   where($criterio,'=',$group)->get(array('resultName','Title','Description','Subject','EuroType'));
		return $resources;
	}
}