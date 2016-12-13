<?php
require_once(MODELS_PATH.'base_model.php');

/**
* 
*/
class SourceType extends BaseModel{
	static function displayName(): string{
		return 'Source type';
	}

	static function selectAllQuery(): string{
		return '';
	}
	
}