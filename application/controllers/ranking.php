<?php

class Ranking_Controller extends Controller {

	function action_saveCalification(){
		$rankingR = new RankingRepository();
		
		$result = $rankingR->insert_Ranking(Input::get('resourceId'),Input::get('scoreResource'),Input::get('userId'));
		if($result){
			$data['msj'] = "Exito";
		}else {
			$data['msj'] = "No se pudo";
		}
		return $data;
		}
} 