<?php
require_once(MODELS_PATH.'base_model.php');

/**
* 
*/
class Source extends BaseModel{
	static function displayName(): string{
		return 'Source';
	}

	static function selectAllQuery(): string{
		return '';
	}
	
}