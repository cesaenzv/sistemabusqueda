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

	public function insert_Ranking($idMetadata, $qualification=1, $userId=1){
		try {
			$newRanking = new Ranking(
								array("id_metadata_term"=>$idMetadata,
									  "idUser"=> $userId,
									  "qualification"=>$qualification)
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
	private function get_MetadataRanking($idMetadata=0){		
		try{
			$rankingAvg = Ranking::where_id_metadata_term($idMetadata)->avg('qualification');
			return $rankingAvg;	
		}
		catch(Exception $e){
			return 1;
		}
	}

	/* Info
		<Desarrollado>
		Carlos Sáenz
		<Resumen>
		-Funcionalidad:
			Metodo encargado de la obtencion del numero de votos realizados a un unico recurso
		-Variables:			
			$idMetadata->Id del recurso del cual quiere identifcar su promedio de calificacion
		-Retorno:
			$rankingCount-> Valor numerico del numero de votos realizados a un recuros
	*/
	private function get_numVotes($idMetadata=0){
		try{
			$rankingAvg = Ranking::where_id_metadata_term($idMetadata)->count();
			return $rankingAvg;	
		}
		catch(Exception $e){
			return 0;
		}
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
	public function get_RankingValues($resources){

		foreach ($resources as $i=>$resource) {
			$resource['ranking'] = $this->get_MetadataRanking($resource['id_metadata_mandatory']);
			$resource['numVotes'] = $this->get_numVotes($resource['id_metadata_mandatory']);
			$resources[$i] = $resource;		
		}
		usort($resources, array("RankingRepository", "cmp"));
		return 	$resources;
	}	

	public function cmp($a, $b)
	{
	    if ($a['ranking'] == $b['ranking']) {
	        return 0;
	    }
	    return ($a['ranking'] > $b['ranking']) ? -1 : 1;
	}
}