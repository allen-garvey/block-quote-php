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

	//should return string array of the names of database columns in model
	//note that the id field should not be included
	//used for insert and update queries
	abstract static function fields(): array;

	protected abstract static function indexSelectQuery(): string;

	//using when updating item
	static function selectOneQuery(): string{
		return 'SELECT * FROM '.static::dbTableName().' WHERE id=$1';
	}

	static function insertQuery(): string{
		$fields = static::fields();
		$fieldNames = implode(',', $fields);
		$fieldPlaceholders = implode(',', array_map(function($i){ return "\$$i"; }, range(1, count($fields))));
		$table = static::dbTableName();
		
		return "INSERT INTO $table ($fieldNames) VALUES ($fieldPlaceholders)";
	}

	static function updateQuery(): string{
		$fields = static::fields();
		$idPlaceholderIndex = count($fields) + 1;
		$fieldPlaceholders = implode(',', array_map(function($field, $i){ return "$field = \$$i"; }, $fields, range(1, count($fields))));
		$table = static::dbTableName();

		return "UPDATE $table SET $fieldPlaceholders WHERE id = \$$idPlaceholderIndex";
	}

	static function deleteQuery(): string{
		return 'DELETE FROM '.static::dbTableName().' WHERE id=$1';
	}

	//should return htmlentities encoded string representation of the item
	abstract static function toHTML(array $model): string;

	static function indexPageOffset(): int{
		return 100;
	}

	
}