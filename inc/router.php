<?php


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
//session imports
require_once(CONTROLLERS_PATH.'flash_controller.php');
require_once(CONTROLLERS_PATH.'session_item_controller.php');
//view helpers
require_once(VIEW_HELPERS_PATH.'url_helper.php');
require_once(VIEW_HELPERS_PATH.'form_helper.php');

//daily quote
require_once(CONTROLLERS_PATH.'daily_quote.php');

//start session
session_start();
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
	//index routes
	if(UriParser::isIndexRoute($path, $models)){
		$model = UriParser::extractModelFromRoute($path, $models);
		$context = array();
		//get flash message if any
		$context['flash'] = FlashController::getFlash();
		
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

	//add and edit routes
	if(UriParser::isAddRoute($path, $models) || UriParser::isEditRoute($path, $models)){
		$model = UriParser::extractModelFromRoute($path, $models);
		$context = array();
		//get flash message if any
		$context['flash'] = FlashController::getFlash();

		//get item from session if there is one
		if(SessionItemController::isItemStored()){
			$context['item'] = SessionItemController::getItem();
		}

		foreach($model::relatedModels() as $relatedModel){
			$context[$relatedModel::filename()] = DbController::select($relatedModel::indexQuery(-1));
		}
		if(UriParser::isAddRoute($path, $models)){
			$context['method'] = UrlHelper::addVerb();
		}
		else{
			$context['method'] = UrlHelper::editVerb();
			//retrieve item if not already saved in session (caused by errors)
			if(!isset($context['item'])){
				$context['item'] = DbController::selectOne($model::selectOneQuery(), $model, UriParser::extractIdFromEditRoute($path));
			}
			if(empty($context['item'])){
				http_response_code(404);
				echo $model::displayName().' not found';
				die();
			}
		}
		include(ADMIN_VIEWS_PATH.'add_edit.php');
		die();
	}
	//delete route
	if(UriParser::isDeleteRoute($path, $models)){
		$model = UriParser::extractModelFromRoute($path, $models);
		$modelId = $_POST['id'];
		//run delete query
		$errorMessage = DbController::delete($model::deleteQuery(), $model, $modelId);
		//set flash for either error message or success message
		if($errorMessage){
			FlashController::setFlash($errorMessage, FlashController::FLASH_ERROR);
		}
		else{
			FlashController::setFlash('Item deleted', FlashController::FLASH_SUCCESS);
		}
		//redirect to index page
		header('Location: '.UrlHelper::indexLinkFor($model));
		die();
	}
	//save route - create or update
	if(UriParser::isSaveRoute($path, $models)){
		$model = UriParser::extractModelFromRoute($path, $models);
		if(UriParser::isUpdateRoute()){
			$isUpdate = true;
			$query = $model::updateQuery();
		}
		else{
			$isUpdate = false;
			$query = $model::insertQuery();
		}
		$values = $model::extractValuesFrom($_POST, $isUpdate);
		$errorMessage = DbController::save($query, $values, $model);
		if($errorMessage){
			//save item values in session
			SessionItemController::setItem($model::extractItemFrom($_POST));
			FlashController::setFlash($errorMessage, FlashController::FLASH_ERROR);
			//redirect back to add/edit page
			if($isUpdate){
				header('Location: '.UrlHelper::editLinkFor($model, $_POST['id']));
			}
			else{
				header('Location: '.UrlHelper::addLinkFor($model));
			}
		}
		else{
			//delete item from session if there is one
			SessionItemController::deleteItem();
			FlashController::setFlash($model::toHTML($_POST).' saved', FlashController::FLASH_SUCCESS);
			//redirect back to add another form if set
			if(UriParser::shouldAddAnother($_POST)){
				SessionItemController::setItem($model::addAnotherValues($_POST));
				header('Location: '.UrlHelper::addLinkFor($model));
			}
			else{
				//redirect to index page
				header('Location: '.UrlHelper::indexLinkFor($model));
			}
		}
		die();
	}
	
}
elseif(preg_match('`^/api/export.sql$`', $uri)){
	header('Content-Type: text/plain');
	require(VIEWS_PATH.'export-sql.php');
	die();
}
//daily quote route
elseif(preg_match('`^/dailyquote.json$`', $uri)){
	header('Content-Type: application/json');
	echo json_encode(DailyQuote::getDailyQuote(), JSON_FORCE_OBJECT);
	die();
}
else{
	//redirect to admin page
	header('Location: '.UrlHelper::adminHomeLink());
	die();
}

//Route not found
http_response_code(404);
echo 'Route not found';