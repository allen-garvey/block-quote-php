<?php 
require_once('../inc/config.php');

$uri = $_SERVER['REQUEST_URI'];

//admin routes
if(preg_match('`^/admin/?`', $uri)){
	$models = ['Authors', 'Quote genres', 'Quotes', 'Source types', 'Sources'];
	//admin home page
	if(preg_match('`^/admin/?$`', $uri)){
		include(ADMIN_VIEWS_PATH.'home.php');
		die();
	}
	$path = preg_replace('`^/admin/`', '', $uri);
	
}
else{
	include(VIEWS_PATH.'home.php');
}






