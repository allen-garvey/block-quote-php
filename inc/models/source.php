<?php
require_once(MODELS_PATH.'base_model.php');

/**
* 
*/
class Source extends BaseModel{
	static function displayName(): string{
		return 'Source';
	}

	protected static function indexSelectQuery(): string{
		return 'SELECT id, title FROM '.self::dbTableName();
	}

	static function toString(array $model): string{
		return $model['title'];
	}
	
}