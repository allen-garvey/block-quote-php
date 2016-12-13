<?php 
require_once('../inc/config.php');

//import models
require_once(MODELS_PATH.'author.php');
require_once(MODELS_PATH.'quote_genre.php');
require_once(MODELS_PATH.'quote.php');
require_once(MODELS_PATH.'source_type.php');
require_once(MODELS_PATH.'source.php');

//routing imports
require_once(CONTROLLERS_PATH.'uri_parser.php');


$uri = $_SERVER['REQUEST_URI'];

//admin routes
if(preg_match('`^/admin/?`', $uri)){
	$models = ['Author', 'QuoteGenre', 'Quote', 'SourceType', 'Source'];
	//admin home page
	if(preg_match('`^/admin/?$`', $uri)){
		include(ADMIN_VIEWS_PATH.'home.php');
		die();
	}
	$path = preg_replace('`^/admin/`', '', $uri);
	if(UriParser::isIndexRoute($path, $models)){
		$model = UriParser::extractModelFromRoute($path, $models);
		include(ADMIN_VIEWS_PATH.'index.php');
		die();
	}
	
}
else{
	include(VIEWS_PATH.'home.php');
	die();
}

//Route not found
http_response_code(404);
echo 'Route not found';






