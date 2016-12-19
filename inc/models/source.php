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

	static function defaultOrdering(): string{
		return ' title';
	}

	static function toHTML(array $model): string{
		return htmlentities($model['title']);
	}

	static function relatedModels(): array{
		return ['Author', 'SourceType', 'Source'];
	}

	static function fields(): array{
		return ['title', 'release_date', 'url', 'author_id', 'parent_source_id', 'source_type_id', 'sort_title'];
	}
	
}