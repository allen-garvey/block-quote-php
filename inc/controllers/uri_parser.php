<?php
/**
* 
*/
class UriParser {
	
	static function isIndexRoute(string $uri, array $models): bool{
		$indexRegex = '`^('.implode('|', array_map(function($model){ return $model::slug(); }, $models)).')/?$`';
		return preg_match($indexRegex, $uri);
	}

	//helper method to determine if route is for add, edit save, etc
	//$verb should be return value from UrlHelper::_verb()
	protected static function isRouteForVerb(string $uri, array $models, string $verb): bool{
		$verbRegex = '`^('.implode('|', array_map(function($model){ return $model::slug(); }, $models)).')/'.$verb.'/?$`';
		return preg_match($verbRegex, $uri);
	}

	static function isAddRoute(string $uri, array $models): bool{
		return self::isRouteForVerb($uri, $models, UrlHelper::addVerb());
	}

	static function isEditRoute(string $uri, array $models): bool{
		$editRegex = '`^('.implode('|', array_map(function($model){ return $model::slug(); }, $models)).')/'.UrlHelper::editVerb().'/\\d+/?$`';
		return preg_match($editRegex, $uri);
	}

	//checks for save route - used for both creating and updating models
	static function isSaveRoute(string $uri, array $models): bool{
		//check that request if POST request
		if($_SERVER['REQUEST_METHOD'] != 'POST'){
			return false;
		}
		//check that id is sent if is for updating
		if((isset($_POST['method']) && strtoupper($_POST['method']) === 'PATCH') && (!isset($_POST['id']) || !is_numeric($_POST['id']) || $_POST['id'] <= 0)){
			return false;
		}
		return self::isRouteForVerb($uri, $models, UrlHelper::saveVerb());
	}

	//check if route is for updating model
	//should be called after isSaveRoute returns true
	static function isUpdateRoute(): bool{
		return isset($_POST['method']) && strtoupper($_POST['method']) === 'PATCH';
	}

	//check if route is for creating a new model and inserting into database
	//should be called after isSaveRoute returns true
	static function isCreateRoute(): bool{
		return !self::isUpdateRoute();
	}

	static function isDeleteRoute(string $uri, array $models): bool{
		//check that request if POST request
		if($_SERVER['REQUEST_METHOD'] != 'POST'){
			return false;
		}
		//check that id to delete is given and valid
		if(!isset($_POST['id']) || !is_numeric($_POST['id']) || $_POST['id'] <= 0){
			return false;
		}

		return self::isRouteForVerb($uri, $models, UrlHelper::deleteVerb());
	}

	//extracts and returns id portion of path from edit uri
	static function extractIdFromEditRoute(string $uri): string{
		$regex = '`^.*'.UrlHelper::editVerb().'/|/$`';
		return preg_replace($regex, '', $uri);
	}

	static function extractModelFromRoute(string $uri, array $models): string{
		$uriBeginning = preg_replace('`^/?|/.*$`', '', $uri);
		
		$routeMap = array();
		foreach($models as $model){
			$routeMap[$model::slug()] = $model;
		}
		return $routeMap[$uriBeginning];
	}

}