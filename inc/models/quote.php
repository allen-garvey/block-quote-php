<?php
require_once(MODELS_PATH.'base_model.php');

/**
* 
*/
class Quote extends BaseModel{
	static function displayName(): string{
		return 'Quote';
	}

	protected static function indexSelectQuery(): string{
		return 'SELECT id, quote_content FROM '.self::dbTableName();
	}

	static function defaultOrdering(): string{
		return ' id';
	}

	static function toString(array $model): string{
		return substr($model['quote_content'], 0, 30);
	}
	
}