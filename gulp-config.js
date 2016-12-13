"use strict";

var path = require('path');
var config = {};

/*
* Environment configuration
*/
config.env = {};
config.env.definitions = require(path.join(__dirname, 'inc', 'environment_definitions.json'));
var current = require( path.join(__dirname, 'inc', 'environment.json'));
config.env.CURRENT = config.env.definitions[current['ENV_CURRENT']];

/*
* JavaScript configuration
*/
config.js = {};
config.js.SOURCE_DIR = path.join(__dirname, 'js/');
config.js.DEST_DIR = path.join(__dirname, 'public_html', 'scripts/');
config.js.DIST_NAME = 'app'; //name of compiled file to be served i.e. app.js and app.min.js
config.js.app_files = ['app'];

//add source dir prefix and .js suffix to js source files
config.js.app_files = config.js.app_files.map(function(file){return path.join(config.js.SOURCE_DIR, file + '.js');});



/*
* Sass/Styles configuration
*/
config.styles = {};
config.styles.SOURCE_DIR = path.join(__dirname, 'sass/');
config.styles.DEST_DIR = path.join(__dirname, 'public_html', 'styles/');
config.styles.sass_options = {
  errLogToConsole: true,
  // sourceComments: true, //turns on line number comments 
  outputStyle: 'compressed' //options: expanded, nested, compact, compressed
};

if(config.env.CURRENT !== config.env.definitions.ENV_PROD){
	config.styles.sass_options.outputStyle = 'expanded';
	config.styles.sass_options.sourceComments = true;
}


/*
* Export config
*/
module.exports = config;



