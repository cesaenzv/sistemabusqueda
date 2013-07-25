<?php

class Ranking_Controller extends Controller {

	function action_saveCalification(){
		$userR = new UserRepository();
		$userIp = $userR->create_VisitorUser();		
		$rankingR = new RankingRepository();		
		$result = $rankingR->insert_Ranking(Input::get('resourceId'),Input::get('scoreResource'),$userIp);
		if($result === true){
			$data['msj'] = "Exito";
		}else {
			$data['msj'] = $result;
		}		
		return Response::json($data);
	}
} 