<?php

/**
* Helps with html output in forms
*/
class FormHelper{
	const EDIT_BUTTON_NAME = '_edit';
	const ADD_BUTTON_NAME = '_save';
	const ADD_ANOTHER_BUTTON_NAME = '_addanother';

	//method should be UrlHelper verbtype
	//returns submit button name
	public static function submitButtonNameForMethod(string $method): string{
		if($method === UrlHelper::editVerb()){
			return self::EDIT_BUTTON_NAME;
		}
		return self::ADD_BUTTON_NAME;
	}

	//returns html encoded value for html input field
	public static function getValue(array $context, string $name): string{
		if(isset($context['item'])){ 
			return htmlentities($context['item'][$name]); 
		}
		return '';
	}

	//used to set correct value as selected for select dropdown
	//doesn't matter what order parameters are passed in
	public static function getSelected(string $value1, string $value2): string{
		if($value1 === $value2){
			return 'selected="selected"';
		}
		return '';
	}
	//formats dropdown name for label
	public static function labelDisplayName(string $input_name): string{
		return htmlentities( ucfirst(preg_replace('/_+/', ' ', $input_name)));
	}

	public static function getRequired(bool $isRequired): string{
		if($isRequired){
			return 'required="required"';
		}
		return '';
	}

	//used for form labels
	public static function getRequiredClass(bool $isRequired): string{
		if($isRequired){
			return 'class="required"';
		}
		return '';
	}

}