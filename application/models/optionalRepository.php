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

	public function insert_Optional($idMetadata,$format,$identifier,$extent,$medium,$rights,$provenance,$relation,
									$conformsTo,$hasFormat,$isFormatOf,$isReferencedBy,$references,$isReplacedBy,
									$replaces,$requires,$tableOfContents,$hasVersion,$isVersionOf,$isRequiredBy,
									$editor){
		try{
			$newData = array( "Format"=>$format,"Identifier"=>$identifier,"Extent"=>$extent,"Medium"=>$medium,
							  "Rights"=>$rights,"Provenance"=>$provenance,"Relation"=>$relation,"ConformsTo"=>$conformsTo,
							  "HasFormat"=>$hasFormat,"IsFormatOf"=>$isFormatOf,"IsReferencedBy"=>$isReferencedBy,
							  "References"=>$references,"IsReplacedBy"=>$isReplacedBy,"Replaces"=>$replaces,"Requires"=>$requires,
							  "TableOfContents"=>$tableOfContents,"HasVersion"=>$hasVersion,"IsVersionOf"=>$isVersionOf,
							  "IsRequiredBy"=>$isRequiredBy,"Editor"=>$editor);
			$metadata = Metadata::find($idMetadata);
			$newOptional = new Optional($newData);
			$newOptional = $metadata->optional->insert($newOptional);
			return $newOptional;
		}catch(Exception $e){
			return false;
		}		
	}
}