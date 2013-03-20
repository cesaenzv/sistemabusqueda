<?php 

class Formc_Controller extends Base_Controller {
	/* Info
		<Desarrollado>
		Carlos Sáenz
		<Resumen>
		-Funcionalidad:
			Metodo que obtiene los campos de cada uno de los modelos, para la creacion de los campos de los formularios
			que se han de presentar al usuario		
		-Retorno: 
			$forms->Objeto json que contien la informacion de los campos de cada uno de los formularios			
	*/


	function __construct(){

		parent::__construct();
		$this->filter('before', 'auth')->only(array('index'));
	}


	function action_getFormFields(){
		$forms = array();
		$mandatoryR = new MandatoryRepository();
		$recommendedR = new RecommendedRepository();
		$optionalR = new OptionalRepository();

		$forms[]=array( 'formName' =>'Formulario Obligatorio',
						'formAttribute' => 'class=step',
						'listAttribute' => 'class=selected',
						'fieldForm'=>$mandatoryR->getFormFields());
		$forms[]=array( 'formName' =>'Formulario Recomendado',
						'formAttribute' => '',
						'listAttribute' => '',
						'fieldForm'=>$recommendedR->getFormFields());
		$forms[]=array( 'formName' =>'Formulario Opcional',
						'formAttribute' => '',
						'listAttribute' => '',
						'fieldForm'=>$optionalR->getFormFields());

		foreach ($forms as $form) {
			$form['fieldForm'] = FormData::checkDataType($form['fieldForm']);
		}
		return Response::json($forms);
	}

	function action_index(){
		return View::make('form');
	}
}