<?php 
class FormData {

	public static function checkDataType ($fields){
		foreach ($fields as $field) {
			switch ($field->data_type) {
				case 'int':
					$field->tagType = "input";
					$field->attribute = 'type="number" min="0"';
					break;
				case 'longtext':
					$field->tagType = "textarea";
					$field->attribute = 'maxlength="1000"';
					break;
				case 'varchar':
					$field->tagType = "textarea";
					$field->attribute = 'maxlength="'.$field->character_maximum_length.'"';
					break;
				case 'set':
					$field->tagType = "select";
					$options = substr($field->column_type, 4);
					$options = trim($options,")");
					$options = explode(",",$options);
					
					for($i=0; $i<count($options);$i++){
						$options[$i] = trim($options[$i],"'");
						$options[$i] = '<option value="'.$options[$i].'">'.$options[$i].'</option>';
					}
					$field->optionsSelect = $options;
					break;
				default:
					$field->tagType = "input";
					$field->attribute = 'type="input" maxlength="'.$field->character_maximum_length.'"';
					break;
			}			
		}
		return $fields;
	}
}