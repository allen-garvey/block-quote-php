<?php
//controller for daily random quote of the day
/**
* 
*/
class DailyQuote{
	public static function dbTableName(): string{
		return 'quotes_dailyquote';
	}

	public static function getDailyQuote(): array{
		//check to see if quote for today is already current
		$dailyQuote = DbController::select(self::dailyQuoteQuery());
		//daily quote is old, select random quote and insert into table
		if(empty($dailyQuote)){
			$previousQuote = DbController::select(self::previousDailyQuoteQuery());
			$previousQuoteId = !empty($previousQuote) ? $previousQuote[0]['quote_id'] : NULL;
			$dailyQuote = self::updateDailyQuote($previousQuoteId);
		}
		else{
			$dailyQuote = $dailyQuote[0];
		}
		//determine author to attribute quote to
		$author = self::determineAuthor($dailyQuote);

		return self::formatQuote($dailyQuote, $author);
	}

	//remove unused rows and format for json output
	protected static function formatQuote(array $quote, array $author): array{
		if(empty($quote)){
			return ['errors' => ['No daily quote found']];
		}
		$formattedQuote = ['data' => []];
		$formattedQuote['data']['id'] = $quote['quote_id'];
		$formattedQuote['data']['body'] = $quote['body'];
		$formattedQuote['data']['source'] = ['title' => $quote['source_title']];
		$formattedQuote['data']['author'] = self::formatAuthor($author);

		return $formattedQuote;
	}

	protected static function formatAuthor(array $author): array{
		if(empty($author)){
			return [];
		}
		return [
				'first_name' => $author['author_first'], 
				'middle_name' => $author['author_middle'],
				'last_name' => $author['author_last']
				];
	}
	
	//determine author to attribute quote to
	//if quote has no author_id then author_id will either be on source or source's parent source
	protected static function determineAuthor(array $quote): array{
		if(empty($quote)){
			return [];
		}
		if(!is_null($quote['quote_author_id'])){
			$authorId = $quote['quote_author_id'];
		}
		else{
			$authorId = $quote['source_author_id'];
		}
		//check to see if we need to get author_id from parent source
		if(is_null($authorId)){
			$author = self::authorForSource($quote['parent_source_id']);
		}
		else{
			$author = DbController::selectOne(Author::selectOneQuery(), 'Author', $authorId);
		}

		return $author;

	}

	//used to get author_id from parent source
	protected static function authorForSource(string $sourceId): string{
		return DbController::selectOneRow(self::getSourceAuthorQuery(), [$sourceId]);
	}

	protected static function getSourceAuthorQuery(): string{
		$authorsTable = Author::dbTableName();
		$sourcesTable = Source::dbTableName();

		return "SELECT {$authorsTable}.author_first AS author_first, {$authorsTable}.author_middle AS author_middle, {$authorsTable}.author_last AS author_last FROM $authorsTable WHERE {$authorsTable}.id = (SELECT author_id FROM $sourcesTable WHERE id = \$1)";
	}

	//inserts a new random quote into the dailyquote table
	//argument is id of last used quote, since we don't want to repeat 
	//yesterday's quote
	protected static function updateDailyQuote(string $lastUsedId=NULL): array{
		$randomQuote = DbController::select(self::randomQuoteQuery());
		//only time this should happen is if quotes table has 1 or less rows
		if(empty($randomQuote)){
			return [];
		}
		$randomQuote = $randomQuote[0];
		DbController::insert(self::insertDailyQuoteQuery($lastUsedId), [$randomQuote['quote_id']]);
		return $randomQuote;
	}

	protected static function insertDailyQuoteQuery(string $quote_id){
		$dailyQuoteTable = self::dbTableName();
		return "INSERT INTO $dailyQuoteTable (quote_id) VALUES (\$1)";
	}

	protected static function randomQuoteQuery(string $lastUsedId=NULL){
		$whereClause = '';
		if(!is_null($lastUsedId)){
			$whereClause = 'WHERE id != $lastUsedId';
		}
		$quotesTable = Quote::dbTableName();
		$quoteSelectClause = self::quoteSelectClause();

		return "$quoteSelectClause $whereClause OFFSET floor(random() * (SELECT count(*) FROM $quotesTable)) LIMIT 1";
	}

	protected static function dailyQuoteQuery(): string{
		$dailyQuoteTable = self::dbTableName();
		$quotesTable = Quote::dbTableName();

		$quoteSelectClause = self::quoteSelectClause();
		
		return "$quoteSelectClause WHERE {$quotesTable}.id = (SELECT quote_id FROM $dailyQuoteTable WHERE date_used >= CURRENT_DATE LIMIT 1)";
	}

	protected static function quoteSelectClause(): string{
		$quotesTable = Quote::dbTableName();
		$sourcesTable = Source::dbTableName();
		return "SELECT {$quotesTable}.id AS quote_id, {$quotesTable}.quote_content AS body, {$quotesTable}.author_id AS quote_author_id, {$sourcesTable}.parent_source_id AS parent_source_id, {$sourcesTable}.author_id AS source_author_id, {$sourcesTable}.title AS source_title FROM $quotesTable INNER JOIN $sourcesTable ON {$sourcesTable}.id = {$quotesTable}.source_id";

	}

	protected static function previousDailyQuoteQuery(): string{
		$dailyQuoteTable = self::dbTableName();
		return "SELECT quote_id FROM $dailyQuoteTable ORDER BY id DESC LIMIT 1";
	}

}