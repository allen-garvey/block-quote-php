<?php
require_once(MODELS_PATH.'base_model.php');

/**
* 
*/
class QuoteGenre extends BaseModel{
	static function displayName(): string{
		return 'Quote genre';
	}

	static function selectAllQuery(): string{
		return '';
	}
	
}