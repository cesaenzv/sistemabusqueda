<?php 

class PieRepository {	
	/* Info
		<desarrollado>
		Carlos Sáenz
		<Resumen>
		-Funcionalidad:
			Metodo encargado de la creación de los pies, mediante la búsqueda en la BD y con respecto a todos los criterios
		-Variables:
			$column -> Representa la columna de la cual se va a construir el pie 
			$termConsult -> Criterio de busqueda, puede recibir dos tipos de valores:1)Busqueda Textual: Termino textual a buscar
																					 2)Busqueda Grafica: Id de metadato o de un europenaterm
			$idColumn -> Identifica cual tipo de id se esta buscando mediante de busqueda: id_europeana_term, id_metadata_term
		-Retorno:
			$pies -> Arreglo que contiene arreglos con informacion de los pies, con los siguiente campos:
				-Column -> Nombre del criterio de búsqueda con el que se contrulle el Pie
				-PieData -> Objeto que contiene la estructura del pie de un criterio para su construccion por medio el API Jit
				-Data -> Arreglo que contiene la informacion contenida dentro del PieData
	*/
	public function generate_Pies($column,$termConsult,$idColumn = "null"){		
		if($idColumn == "null"){			
			$metadatas = DB::table('metadata AS m')
				->join('europeanaterms AS e', 'm.id_europeana_term', '=', 'e.id_europeana_term')
				->join('metadatamandatory AS ma', 'm.id_metadata_term', '=', 'ma.id_metadata_mandatory')
				->where_termNameUtf8($termConsult)->group_by($column)
				->get(array("$column AS column",DB::raw("count($column) AS numresources")));					
			$pies=array('Column' => $column ,'PieData'=>$this->create_JsonPie($column,$metadatas),'Data'=>$metadatas);			
		}
		else{			
			$metadatas = DB::table('metadata AS m')
							->join('europeanaterms AS e', 'm.id_europeana_term', '=', 'e.id_europeana_term')
							->join('metadatamandatory AS ma', 'm.id_metadata_term', '=', 'ma.id_metadata_mandatory')
							->where($idColumn, '=',$termConsult)
							->group_by($column)
							->get(array("$column AS column",DB::raw("count($column) AS numresources")));
			$pies=array('Column' => $column ,'PieData'=>$this->create_JsonPie($column,$metadatas),'Data'=>$metadatas);	
		}
		return $pies;	
	}

	/* Info
		<desarrollador>
		Carlos Sáenz
		<Resumen>
		-Funcionalidad:
			Metodo encargado de crear el cuerpo del pie para su construccion en Json
		-Variables:
			$criterion -> Criterio de consulta con respecto a la consulta de los pies
			$metadatas -> Informacion de los pies (Secciones dentro del pie)
		-Retorno:
			$pieData -> Objeto que contiene la estructura del pie de un criterio para su construccion por medio el API Jit
	*/
	private function create_JsonPie($criterio,$metadatas){		
		$pie=array();
		foreach($metadatas as $metadata) {
			$pie[]=array('label'=>$metadata->column,'values'=>$metadata->numresources);
		}
		$pieData = array('label'=>$criterio,'values'=>$pie);
		return $pieData;
	}

}

