<?php
/*
* Exports database as sql for import into block quote phoenix
* https://github.com/allen-garvey/block-quote-phoenix
*/

function printTable(string $selectStatement, callable $rowCallback){
	$tableData = DbController::select($selectStatement);

	foreach (DbController::select($selectStatement) as $row) {
		echo $rowCallback($row), PHP_EOL;
	}
}

function sqlEscapeString(string $string): string{
	$escapedString = str_replace("'", "''", $string);
	return "'$escapedString'";
}

function sqlOptionalString(string $string=null): string{
	if(empty($string)){
		return 'NULL';
	}
	return sqlEscapeString($string);
}

function sqlOptionalInt(int $int=null){
	if(empty($int) && $int !== 0){
		return 'NULL';
	}
	return $int;
}
function sqlOptionalDate(string $date): string{
	if(empty($date)){
		return 'NULL';
	}
	return $date;
}

function sectionComment(string $tableDescription){
	echo PHP_EOL, PHP_EOL, "--$tableDescription", PHP_EOL, PHP_EOL;
}

/*
* Authors
*/
sectionComment('Authors');
printTable("SELECT * FROM quotes_author ORDER BY id;", function($row){
	$id = $row['id'];
	$firstName = sqlEscapeString($row['author_first']);
	$middleName = sqlOptionalString($row['author_middle']);
	$lastName = sqlOptionalString($row['author_last']);

	return "INSERT INTO authors (id, first_name, middle_name, last_name, inserted_at, updated_at) VALUES ($id, $firstName, $middleName, $lastName, now(), now());";
});


/*
* Quote Categories
*/
sectionComment('Quote Categories');
printTable("SELECT * FROM quotes_quotegenre ORDER BY id;", function($row){
	$id = $row['id'];
	$name = sqlEscapeString($row['name']);

	return "INSERT INTO categories (id, name, inserted_at, updated_at) VALUES ($id, $name, now(), now());";
});


/*
* Source Types
*/
sectionComment('Source Types');
printTable("SELECT * FROM quotes_sourcetype ORDER BY id;", function($row){
	$id = $row['id'];
	$name = sqlEscapeString($row['name']);

	return "INSERT INTO source_types (id, name, inserted_at, updated_at) VALUES ($id, $name, now(), now());";
});


/*
* Parent sources
*/
sectionComment('Parent sources');
printTable("SELECT * FROM quotes_source WHERE id IN (SELECT parent_source_id from quotes_source WHERE parent_source_id IS NOT NULL) ORDER BY id;", function($row){
	$id = $row['id'];
	$title = sqlEscapeString($row['title']);
	$url = sqlOptionalString($row['url']);
	$sourceTypeId = $row['source_type_id'];

	return "INSERT INTO source_types (id, title, url, source_type_id, inserted_at, updated_at) VALUES ($id, $title, $url, $sourceTypeId, now(), now());";
});


/*
* Sources
*/
//remember that some sources get the author from the parent source, so you need a left join to get it here
// sectionComment('Sources');
// printTable("SELECT * FROM quotes_source WHERE id IN (SELECT parent_source_id from quotes_source WHERE parent_source_id IS NOT NULL) ORDER BY id;", function($row){
// 	$id = $row['id'];
// 	$title = sqlEscapeString($row['title']);
// 	$releaseDate = sqlOptionalDate($row['release_date']);
// 	$url = sqlOptionalString($row['url']);
// 	$authorId = sqlOptionalInt($row['author_id']);

// 	return "INSERT INTO source_types (id, name, inserted_at, updated_at) VALUES ($id, $name, now(), now());";
// });