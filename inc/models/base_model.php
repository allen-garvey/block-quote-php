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
		return preg_replace('/\\s+/', '-', strtolower(static::displayNamePlural()));
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

	protected abstract static function indexSelectQuery(): string;

	static function selectOneQuery(): string{
		return '';
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

	abstract static function toString(array $model): string;

	static function indexPageOffset(): int{
		return 100;
	}

	
}