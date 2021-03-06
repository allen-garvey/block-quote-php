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
		return 'id DESC';
	}

	static function toHTML(array $model): string{
		$excerptLength = 120;
		$content = $model['quote_content'];
		$excerpt = htmlentities(substr($content, 0, $excerptLength));
		//add ellipsis if content was truncated
		if(strlen($content) > $excerptLength){
			$excerpt = $excerpt.'&hellip;';
		}
		return $excerpt;
	}

	static function relatedModels(): array{
		return ['Author', 'QuoteGenre', 'Source'];
	}

	static function fields(): array{
		return ['quote_content', 'author_id', 'source_id', 'genre_id'];
	}

	static function addAnotherFields(): array{
		return ['author_id', 'source_id', 'genre_id'];
	}
	
}