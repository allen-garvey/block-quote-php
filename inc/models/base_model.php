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

	//returns array of values extracted from associative array (e.g. $_POST)
	//in correct order for insert or update query
	static function extractValuesFrom(array $array, bool $isUpdate=false): array{
		$fields = static::fields();
		if($isUpdate){
			$fields[] = 'id';
		}
		$values = array_map(function($field) use ($array){ return self::extractValue($field, $array); }, $fields);
		return $values;
	}

	//returns either a string value from array if it exists or null
	//if it is empty or doesn't exist
	static function extractValue(string $key, array $array){
		if(isset($array[$key]) && $array[$key] != ''){
			return $array[$key];
		}
		return null;
	}

	//used to save model with errors to session
	static function extractItemFrom(array $array): array{
		$fields = static::fields();
		if($isUpdate){
			$fields[] = 'id';
		}
		$item = array();
		foreach ($fields as $field){
			$item[$field] = self::extractValue($field, $array);
		}
		return $item;
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

	//fields that should be duplicated when 'save and add another' button is pressed
	//by default, none are, so the array is empty
	//override this function if you want values to be duplicated when 'add another' button
	//is used
	static function addAnotherFields(): array{
		return [];
	}

	//returns associative array of fields to values used
	//when values are duplicated for add another item
	static function addAnotherValues(array $post): array{
		$item = array();
		$addAnotherFields = static::addAnotherFields();
		foreach($addAnotherFields as $field){
			$item[$field] = $post[$field];
		}

		return $item;
	}

	
}