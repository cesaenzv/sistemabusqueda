<?php

class Ranking_Controller extends Controller {

	/* Info
		<Desarrollado>
		Carlos Sáenz
		<Resumen>
		-Funcionalidad:
			Metodo encargado de guarda un nuevo ranking, que realiza una persona que usa la aplicacion		
		-Retorno: 
			$data -> Envia el exito o fracaso del proceso		
	*/
	function action_saveCalification(){
		$userR = new UserRepository();
		$user = $userR->create_VisitorUser();		
		$rankingR = new RankingRepository();		
		$result = $rankingR->insert_Ranking(Input::get('resourceId'),Input::get('scoreResource'),$user->id);
		if($result === true){
			$data['msj'] = "Exito";
		}else {
			$data['msj'] = $result;
		}		
		return Response::json($data);
	}
} 