<?php

/**
* Using to correctly generate  urls 
*/
class UrlHelper{

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
		return self::indexLinkFor($model).'/add';
	}

	//return string url to edit an item
	static function editLinkFor(string $model, int $itemId): string{
		return self::indexLinkFor($model).'/edit/'.$itemId;
	}
}