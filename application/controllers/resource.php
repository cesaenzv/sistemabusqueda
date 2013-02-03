<?php

class Resource_Controller extends Base_Controller {


	
	public function action_index(){
		return View::make('home.index');
	}

	/* Info
		<Desarrollado>
		Carlos Sáenz
		<Resumen>
		-Funcionalidad:
			Metodo que solicita la creacion de los pies, ya sea la consulta por medio de termino textual o por medio de la 
			id de los terminos
		-Variables Input:
			term -> Termino de busqueda textual
			idColumn -> Columna en la cual se realiza la busqueda de la Id
			idTerm -> Id que identifica el termino por el cual se realiza la consulta de los pies
		-Retorno: 
			Objeto json que contien la informacion de los pies con todos los criterio implementados
			PD:Si la busqueda fue por medio textual, regresa un dato mas el cual contiene el ID de este termino
	*/
	public function action_getPies(){
		$pieRepository = new PieRepository();
		$termRepository = new europeanaTermRepository();
		$datos = array();
		try{		
			if(Input::get('term')){
				$datos['pie'] = $pieRepository->generate_Pies(Input::get('criterio'),Input::get('term'));	
				$europeanaTermRepository = new EuropeanaTermRepository();
				$datos['id'] = $europeanaTermRepository->get_IdByTerm(Input::get('term'));
				return Response::json($datos);		
			}
			$datos['pie'] = $pieRepository->generate_Pies(Input::get('criterio'),Input::get('idTerm'),Input::get('idColumn'));			
			return Response::json($datos);
		}
		catch(Exception $error){
			$datos['mensaje'] = "Hubo un problema". $error->getMessage();
			return Response::json($datos);
		}		
	}

	/* Info
		<Desarrollado>
		Carlos Sáenz
		<Resumen>
		-Funcionalidad:
			Metodo encargado de la recuperación de ciertos recursos asociados a un termino, por medio a un criterio de separacion y 
			un sub grupo de este criterio
		-Variables Input:
			criterio -> Criterio que realiza la agrupacion de los metada
			group -> Sub grupo del criterio por el cual se realiza la busqueda
			idTerm -> Id que identifica el termino por el cual se realiza la consulta de los pies
		-Retorno -> 
			Objeto json que contien la informacion de los recursos
			PD:Si la busqueda fue por medio textual, regresa un dato mas el cual contiene el ID de este termino
	*/
	public function action_getResource(){		
		try{
			$metadataRepository = new MetadataRepository();
			$datos['resources'] = $metadataRepository->getMetadataResourceList(Input::get('criterio'),Input::get('group'),Input::get('idTerm'));
			return Response::json($datos);
		}
		catch(Exception $error){
			$datos['mensaje'] = "Hubo un problema";
			return Response::json($datos);
		}
	}
	
}