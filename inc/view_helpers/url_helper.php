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
}