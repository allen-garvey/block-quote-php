<?php 

function json_from_path($path){
	return json_decode(file_get_contents($path), true);
}

function setup_environment(){
	$environment_definitions = json_from_path(INC_PATH.'environment_definitions.json');
	foreach ($environment_definitions as $key => $value) {
		define($key, $value);
	}
	$current_env = json_from_path(INC_PATH.'environment.json');
	define('ENV_CURRENT', $environment_definitions[$current_env['ENV_CURRENT']]);
}

setup_environment();