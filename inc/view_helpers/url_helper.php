<?php

/**
* Using to correctly generate  urls 
*/
class UrlHelper{

	//string added to urls to represent 'add' action (show add item form)
	static function addVerb(): string{
		return 'add';
	}

	//string added to urls to represent 'edit' action (show edit item form)
	static function editVerb(): string{
		return 'edit';
	}

	//string added to urls to represent 'delete' action (delete item)
	static function deleteVerb(): string{
		return 'delete';
	}

	//string added to urls to represent 'save' action (update or create item)
	static function saveVerb(): string{
		return 'save';
	}


	//returns string url for admin home page
	static function adminHomeLink(): string{
		return '/admin';
	}

	//returns string url for admin page index link
	static function indexLinkFor(string $model): string{
		return self::adminHomeLink().'/'.$model::slug();
	}

	//returns string url to add new item to model
	static function addLinkFor(string $model): string{
		return self::indexLinkFor($model).'/'.self::addVerb();
	}

	//return string url to edit an item
	static function editLinkFor(string $model, int $itemId): string{
		return self::indexLinkFor($model).'/'.self::editVerb().'/'.$itemId;
	}

	//return string url to delete an item
	static function deleteLinkFor(string $model): string{
		return self::indexLinkFor($model).'/'.self::deleteVerb();
	}

	//return string url to save an item (update or delete)
	static function saveLinkFor(string $model): string{
		return self::indexLinkFor($model).'/'.self::saveVerb();
	}

}