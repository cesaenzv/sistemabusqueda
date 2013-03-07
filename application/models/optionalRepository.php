<?php 

class OptionalRepository {

	/* Info
		<Desarrollado>
		Carlos Sáenz
		<Resumen>
		-Funcionalidad:
			Metodo encargado de obtener de cada modelo en nombre y el tipo de dato de cada uno de los campos correspodientes
			dentro de la base de datos				
		-Retorno:
			$fields->Arreglo que contiene la informacion de los atributos de la base de datos
	*/
	public function getFormFields(){
		$fields = DB::table('metadataOptional')->columns('id_metadata_optional');
		return $fields;
	}
}