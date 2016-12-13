<?php
require_once(MODELS_PATH.'base_model.php');

/**
* 
*/
class Author extends BaseModel{
	static function displayName(): string{
		return 'Author';
	}

	protected static function indexSelectQuery(): string{
		return 'SELECT id, author_first, author_middle, author_last FROM '.self::dbTableName();
	}

	static function defaultOrdering(): string{
		return ' author_last, author_first, author_middle';
	}

	static function toString(array $model): string{
		return $model['author_first'];
	}
}