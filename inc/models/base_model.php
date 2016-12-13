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

	static function slug(): string{
		return preg_replace('/\\s+/', '-', strtolower(static::displayNamePlural()));
	}

	static function dbTableName(): string{
		return 'quotes_'.preg_replace('/\\s/', '', strtolower(static::displayName()));
	}

	abstract static function selectAllQuery(): string;

	static function insertQuery(): string{
		return '';
	}

	static function updateQuery(): string{
		return '';
	}

	static function deleteQuery(): string{
		return 'DELETE FROM '.static::dbTableName().' WHERE id=?';
	}


	
}