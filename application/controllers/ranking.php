<?php

class Ranking_Controller extends Controller {

	function action_saveCalification(){
		$rankingR = new RankingRepository();		
		$result = $rankingR->insert_Ranking(Input::get('resourceId'),Input::get('scoreResource'));
		if($result === true){
			$data['msj'] = "Exito";
		}else {
			$data['msj'] = $result;
		}		
		return Response::json($data);
	}
} 