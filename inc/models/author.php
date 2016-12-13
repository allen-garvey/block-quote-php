<?php
require_once(MODELS_PATH.'base_model.php');

/**
* 
*/
class Author extends BaseModel{
	static function displayName(): string{
		return 'Author';
	}

	static function selectAllQuery(): string{
		return '';
	}
	
}