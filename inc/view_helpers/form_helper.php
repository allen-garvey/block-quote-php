<?php

/**
* Helps with html output in forms
*/
class FormHelper{
	//returns html encoded value for html input field
	public static function getValue(array $context, string $name): string{
		if($context['method'] === UrlHelper::editVerb()){ 
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
}