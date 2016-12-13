<?php
require_once(MODELS_PATH.'base_model.php');

/**
* 
*/
class Quote extends BaseModel{
	static function displayName(): string{
		return 'Quote';
	}

	static function selectAllQuery(): string{
		return '';
	}
	
}