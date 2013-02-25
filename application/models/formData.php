<?php 
class FormData {

	public static function checkDataType ($fields){
		foreach ($fields as $field) {
			switch ($field->column_type) {
				case 'int(11)':
					$field->column_type = "number";
					$field->attribute = 'min="0"';
					break;
				case 'longtext':
					$field->column_type = "textarea";
					$field->attribute = 'maxlength="500"';
					break;				
				default:
					$field->column_type ="text";
					$field->attribute = ' ';
					break;
			}			
		}
		return $fields;
	}
}