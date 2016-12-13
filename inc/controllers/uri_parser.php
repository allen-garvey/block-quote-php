<?php
/**
* 
*/
class UriParser {
	
	static function isIndexRoute(string $uri, array $models): bool{
		$indexRegex = '`^'.implode('|', array_map(function($model){ return $model::slug(); }, $models)).'/?$`';
		return preg_match($indexRegex, $uri);
	}
}