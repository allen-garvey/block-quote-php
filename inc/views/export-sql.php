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

/*
* Fixes id sequence, since we bypassed it when doing these inserts
* from: https://stackoverflow.com/questions/244243/how-to-reset-postgres-primary-key-sequence-when-it-falls-out-of-sync
*/
function resetIdSequence(string $tableName){
	echo "--Reset $tableName sequence", PHP_EOL;
	echo "SELECT setval(pg_get_serial_sequence('$tableName', 'id'), COALESCE(MAX(id), 1), MAX(id) IS NOT null) FROM $tableName;", PHP_EOL;
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
function sqlOptionIntCoalesce(int $int1=null, int $int2=null){
	$int1Value = sqlOptionalInt($int1); 
	if($int1Value === 'NULL'){
		return sqlOptionalInt($int2);
	}
	return $int1Value;
}

function sqlDate(string $date): string{
	return "to_date('$date', 'YYYY-MM-DD')";
}

function sqlOptionalDate(string $date=null): string{
	if(empty($date)){
		return 'NULL';
	}
	return sqlDate($date);
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
	$sortTitle = sqlEscapeString($row['sort_title']);
	$title = sqlEscapeString($row['title']);
	$url = sqlOptionalString($row['url']);
	$sourceTypeId = $row['source_type_id'];

	return "INSERT INTO parent_sources (id, sort_title, title, url, source_type_id, inserted_at, updated_at) VALUES ($id, $sortTitle, $title, $url, $sourceTypeId, now(), now());";
});


/*
* Sources
*/
//some sources get the author from the parent source, so you need a left join to get it here
sectionComment('Sources');
printTable("SELECT source.id id, source.title title, source.sort_title sort_title, source.url url, source.parent_source_id parent_source_id, source.source_type_id source_type_id, source.release_date release_date, source.author_id author_id, parent_source.author_id parent_author_id FROM quotes_source AS source LEFT JOIN quotes_source as parent_source ON source.parent_source_id = parent_source.id WHERE source.id NOT IN (SELECT parent_source_id from quotes_source WHERE parent_source_id IS NOT NULL) ORDER BY source.id;", function($row){
	$id = $row['id'];
	$title = sqlEscapeString($row['title']);
	$sortTitle = sqlEscapeString($row['sort_title']);
	$title = sqlEscapeString($row['title']);
	$url = sqlOptionalString($row['url']);
	$sourceTypeId = $row['source_type_id'];
	$parentSourceId = sqlOptionalInt($row['parent_source_id']);
	$releaseDate = sqlOptionalDate($row['release_date']);
	$authorId = sqlOptionIntCoalesce($row['author_id'], $row['parent_author_id']);

	return "INSERT INTO sources (id, author_id, sort_title, title, url, source_type_id, parent_source_id, release_date, inserted_at, updated_at) VALUES ($id, $authorId, $sortTitle, $title, $url, $sourceTypeId, $parentSourceId, $releaseDate, now(), now());";
});

/*
* Quotes
*/
sectionComment('Quotes');
printTable("SELECT * FROM quotes_quote ORDER BY id;", function($row){
	$id = $row['id'];
	$dateAdded = sqlDate($row['date_added']);
	$body = sqlEscapeString($row['quote_content']);
	$categoryId = $row['genre_id'];
	$authorId = sqlOptionalInt($row['author_id']);
	$sourceId = $row['source_id'];

	return "INSERT INTO quotes (id, body, category_id, author_id, source_id, inserted_at, updated_at) VALUES ($id, $body, $categoryId, $authorId, $sourceId, $dateAdded, now());";
});

sectionComment('Daily quotes');
printTable("SELECT id, date_used::date, quote_id FROM quotes_dailyquote ORDER BY id;", function($row){
	$id = $row['id'];
	$dateUsed = sqlDate($row['date_used']);
	$quoteId = $row['quote_id'];

	return "INSERT INTO daily_quotes (id, quote_id, date_used, inserted_at, updated_at) VALUES ($id, $quoteId, $dateUsed, now(), now());";
});




/*
* Reset Id sequences
*/
sectionComment('Reset Id sequences');
resetIdSequence('authors');
resetIdSequence('categories');
resetIdSequence('source_types');
resetIdSequence('parent_sources');
resetIdSequence('sources');
resetIdSequence('quotes');
resetIdSequence('daily_quotes');