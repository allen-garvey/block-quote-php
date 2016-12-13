<?php
/**
* 
*/
class UriParser {
	
	static function isIndexRoute(string $uri, array $models): bool{
		$indexRegex = '`^'.implode('|', array_map(function($model){ return $model::slug(); }, $models)).'/?$`';
		return preg_match($indexRegex, $uri);
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