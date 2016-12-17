<?php
/**
* 
*/
class UriParser {
	
	static function isIndexRoute(string $uri, array $models): bool{
		$indexRegex = '`^('.implode('|', array_map(function($model){ return $model::slug(); }, $models)).')/?$`';
		return preg_match($indexRegex, $uri);
	}

	static function isAddRoute(string $uri, array $models): bool{
		$addRegex = '`^('.implode('|', array_map(function($model){ return $model::slug(); }, $models)).')/'.UrlHelper::addVerb().'/?$`';
		return preg_match($addRegex, $uri);
	}

	static function isEditRoute(string $uri, array $models): bool{
		$editRegex = '`^('.implode('|', array_map(function($model){ return $model::slug(); }, $models)).')/'.UrlHelper::editVerb().'/\\d+/?$`';
		return preg_match($editRegex, $uri);
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
		$deleteRouteRegex = '`^('.implode('|', array_map(function($model){ return $model::slug(); }, $models)).')/'.UrlHelper::deleteVerb().'/?$`';

		return preg_match($deleteRouteRegex, $uri);
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