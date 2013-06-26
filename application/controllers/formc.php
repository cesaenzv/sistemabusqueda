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

		$terminos = EuropeanaTerm::lists('termnameutf8','id_europeana_term');
		//dd($terminos);
		return View::make('form')->with('terminos',$terminos);
	}

	/* Info
		<Desarrollado>
		Carlos Sáenz
		<Resumen>
		-Funcionalidad:
			Metodo encargado de la creacion de un nuevo metadatado, partiendo de la creacion del mismo 
			y si esto es realizado se realiza la insercion de las tablas asociadas al metadato
		-Retorno: 
			$mensaje->Respuesta de mensaje de exito o fallo de la insercion del nuevo metadato
	*/
	function action_saveFormData(){
		//dd(Input::all());
		$metadataId;
		$mensaje =array();
		$metadataR = new MetadataRepository();
		$newMetadata = $metadataR->insert_Metadata(Input::get('id_europeana_term'), Input::get('ParentKey'));
		if($newMetadata){			
			$metadataId = $newMetadata->id_metadata_term;
			$mensaje["metadata"] = "Ok";						
		}else{
			$mensaje["metadata"] = "Problema";
			return Response::json($mensaje);
		}
		$mandatoryR = new MandatoryRepository();
		$resultMandatory = $mandatoryR->insert_Mandatory($metadataId);
		if($resultMandatory){
			$mensaje["mandatory"] =  "Ok";
		}else{
			$mensaje["mandatory"] =  "Problema";
		}
		$recommendedR = new RecommendedRepository();
		$resultRecommended = $recommendedR->insert_Recommended($metadataId);
		if($resultRecommended){
			$mensaje["recommended"] =  "Ok";
		}else{
			$mensaje["recommended"] = "Problema";
		}
		$optionalR = new MandatoryRepository();
		$resultOptional = $optinalR->insert_Optional($metadataId);
		if($resultOptional){
			$mensaje["optinal"] =  "Ok";
		}else{
			$mensaje["optional"] =  "Problema";
		}
		return Response::json($mensaje);

	}
}