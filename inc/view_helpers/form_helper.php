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
}