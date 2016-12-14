<?php 

/**
* Basis for ORM classes 
*/
abstract class BaseModel{
	abstract static function displayName(): string;
	
	static function displayNamePlural(): string{
		return static::displayName().'s';
	}

	static function name(): string{
		return strtolower(static::displayName());
	}

	static function namePlural(): string{
		return static::name().'s';
	}

	static function slug(): string{
		return rawurlencode(preg_replace('/\\s+/', '-', strtolower(static::displayNamePlural())));
	}

	//used for loading views form
	static function filename(): string{
		return preg_replace('/\\s+/', '_', static::name());
	}

	static function dbTableName(): string{
		return 'quotes_'.preg_replace('/\\s/', '', strtolower(static::displayName()));
	}

	static function countQuery(): string{
		return 'SELECT count(*) as count FROM '.static::dbTableName();
	}

	abstract static function defaultOrdering(): string;

	static function indexQuery(int $offset=-1): string{
		$baseQuery = static::indexSelectQuery();
		$query = $baseQuery.' ORDER BY '.static::defaultOrdering();
		
		if($offset >= 0){
			$columnOffset = ($offset - 1) * self::indexPageOffset();
			$query = $query.' LIMIT '.self::indexPageOffset().' OFFSET '.$columnOffset;
		}

		return $query;
	}

	//should return list of string of model class names
	//used to populate select fields in forms
	static function relatedModels(): array{
		return [];
	}

	protected abstract static function indexSelectQuery(): string;

	//using when updating item
	static function selectOneQuery(): string{
		return 'SELECT * FROM '.static::dbTableName().' WHERE id=$1';
	}

	static function insertQuery(): string{
		return '';
	}

	static function updateQuery(): string{
		return '';
	}

	static function deleteQuery(): string{
		return 'DELETE FROM '.static::dbTableName().' WHERE id=?';
	}

	//should return htmlentities encoded string representation of the item
	abstract static function toHTML(array $model): string;

	static function indexPageOffset(): int{
		return 100;
	}

	
}