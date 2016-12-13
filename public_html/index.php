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
//database imports
require_once(CONTROLLERS_PATH.'db_controller.php');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

//admin routes
if(preg_match('`^/admin/?`', $uri)){
	//remove admin prefix
	$path = preg_replace('`^/admin/?`', '', $uri);
	$models = ['Author', 'QuoteGenre', 'Quote', 'SourceType', 'Source'];
	//admin home page
	if($path === ''){
		include(ADMIN_VIEWS_PATH.'home.php');
		die();
	}
	if(UriParser::isIndexRoute($path, $models)){
		$model = UriParser::extractModelFromRoute($path, $models);
		$context = array();
		
		$context['items_count'] = DbController::select($model::countQuery())[0]['count'];
		$context['num_pages'] = (int) ceil($context['items_count'] * 1.0 / $model::indexPageOffset());
		if(isset($_GET['p']) && is_numeric($_GET['p']) && $_GET['p'] <= $context['num_pages']){
			$context['current_page'] = (int) $_GET['p'];
		}
		else{
			$context['current_page'] = 1;
		}
		$context['items'] = DbController::select($model::indexQuery($context['current_page']));

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






