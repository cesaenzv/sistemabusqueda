<?php

class Text_Controller extends Base_Controller{
	
	public function action_index(){
		return View::make('home.index');
	}


	/* Info
		<Desarrollado>
		Carlos Sáenz
		<Resumen>
		-Funcionalidad:
			Metodo que obtiene una lista de todos los terminos encontrados dentro de la base de datos		
		-Retorno: 
			$terms->Listado de los terminos
	*/
	public function action_loadTermsSearch(){
		$europeanaTR = new EuropeanaTermRepository();
		$terms = $europeanaTR->get_TermList();
		return Response::json($terms);
	}
	
}