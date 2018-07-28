# Block Quote PHP

Inspirational quote CMS. Admin styles based on Django admin.

## Dependencies

* PHP 7 or higher
* PostgreSQL
* Nodejs 4.4 or higher with npm and gulp (for JavaScript and Sass compilation/minification)
* npm to install dependencies
* Bash and POSIX compatible operating system (for initial project setup scripts)

## Getting Started

* `cd` into downloaded project directory
* Type `npm install` to install dependencies
* Type `npm run setup` to initialize configuration files
* Edit the `inc/environment.json` file to set the current environment variables
* Edit the `inc/db.php` file with your PostgreSQL connection settings
* Type `npm run gulp` to compile raw JavaScript files and scss files
* Type `npm run gulp:watch` to watch for changes in JavaScript and scss files and build as necessary

## License

Block Quote PHP is released under the MIT License. See license.txt for more details.