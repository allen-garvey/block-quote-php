<?php
	//used to control access to item stored in the session
	//used when trying to save and item with errors and need to preload form
	//or when saving and adding another

/**
* 
*/
class SessionItemController{
	const SESSION_ITEM_KEY = 'item';

	//stores given item in session
	static function setItem(array $item){
		$_SESSION[self::SESSION_ITEM_KEY] = $item;
	}

	//returns item and deletes from session
	//so it does not persist between pages
	static function getItem(): array{
		if(self::isItemStored()){
			$item = $_SESSION[self::SESSION_ITEM_KEY];
			self::deleteItem();
			return $item;
		}
		return [];
	}

	//used to check if item is saved in session
	static function isItemStored(): bool{
		return isset($_SESSION[self::SESSION_ITEM_KEY]) && !empty($_SESSION[self::SESSION_ITEM_KEY]);
	}
	//deletes item from session
	static function deleteItem(){
		unset($_SESSION[self::SESSION_ITEM_KEY]);
	}
	
}

