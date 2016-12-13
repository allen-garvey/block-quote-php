<?php
require_once(MODELS_PATH.'base_model.php');

/**
* 
*/
class QuoteGenre extends BaseModel{
	static function displayName(): string{
		return 'Quote genre';
	}

	protected static function indexSelectQuery(): string{
		return 'SELECT id, name FROM '.self::dbTableName();
	}

	static function toString(array $model): string{
		return $model['name'];
	}
	
}