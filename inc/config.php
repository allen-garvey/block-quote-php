<?php 
//paths
define('ROOT_PATH', dirname(__FILE__, 2).'/');
define('INC_PATH', ROOT_PATH.'inc/');
define('VIEWS_PATH', INC_PATH.'views/');
define('ADMIN_VIEWS_PATH', INC_PATH.'views/admin/');
define('CONTROLLERS_PATH', INC_PATH.'controllers/');
define('MODELS_PATH', INC_PATH.'models/');

require_once(INC_PATH.'environment_setup.php');


define('BASE_URL','http://quotes.alaska.dev/');

define('STYLES_URL', BASE_URL.'styles/');
define('SCRIPTS_URL', BASE_URL.'scripts/');

