<?php

class RankingRepository{

	/* Info
		<Desarrollado>
		Carlos Sáenz
		<Resumen>
		-Funcionalidad:
			Metodo encargado de guardar un nuevo objeto ranking dentro de la base dedatos relacionado a un metadata
		-Variables:			
			$idMetadata->Id de un recurso especifico
			$qualification->Calificacion dada al recurso especifico
			$idUser->Id del usuario que esta calificando el recurso
		-Retorno:
			$newRanking-> Objeto de tipo ranking, el cual es una nueva calificacion de un recurso especifico
	*/
	function insert_Ranking($idMetadata, $qualification, $idUser){
		try {
			$newRanking = new Ranking(
								array("id_metadata_term"=>$idMetadata, 
									  "qualification"=>$qualification, 
									  "idUser" => $idUser)
							);
			$metadata = Metadata::find($idMetadata);			
			$newRanking = $metadata->ranking()->insert($newRanking);			
			return true;
		}catch(Exception $e){
			return $e->getMessage();
		}

	}

	/* Info
		<Desarrollado>
		Carlos Sáenz
		<Resumen>
		-Funcionalidad:
			Metodo encargado de la recoleccion del valor promedio de las calificaciones asociadas a un metadata 
			especifico
		-Variables:			
			$idMetadata->Id del recurso del cual quiere identifcar su promedio de calificacion
		-Retorno:
			$rankingAvg-> Valor numero del promedio de todos los rankings asociados al metadata
	*/
	function get_MetadataRanking($idMetadata){
		$rankingAvg = Ranking::where_id_metadata_term($idMetadata)->avg();		 
		return $rankingAvg;
	}

	/* Info
		<Desarrollado>
		Carlos Sáenz
		<Resumen>
		-Funcionalidad:
			Metodo encargado de la recoleccion del valor promedio de las calificaciones asociados 
		-Variables:			
			$resources->Array de los recursos recuperados desde la base de datos
		-Retorno:
			$resources-> Array de los recursos recuperados desde la base de datos con el valor agregado del 
			ranking
	*/
	function get_RankingValues($resources){
		foreach ($resources as $resource) {
			$resource["ranking"] = $this.get_MetadataRanking($resource->idResource);
		}
		return $resources;
	}
}