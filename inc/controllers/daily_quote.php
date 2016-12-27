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
		//determine author

		return $dailyQuote;
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
		DbController::insert(self::insertDailyQuoteQuery($lastUsedId), [$randomQuote['id']]);
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
		return "SELECT * FROM $quotesTable $whereClause OFFSET floor(random() * (SELECT count(*) FROM $quotesTable)) LIMIT 1";
	}

	protected static function dailyQuoteQuery(): string{
		$dailyQuoteTable = self::dbTableName();
		$quotesTable = Quote::dbTableName();
		return "SELECT * FROM $quotesTable WHERE id = (SELECT quote_id FROM $dailyQuoteTable WHERE date_used >= CURRENT_DATE LIMIT 1)";
	}

	protected static function previousDailyQuoteQuery(): string{
		$dailyQuoteTable = self::dbTableName();
		return "SELECT quote_id FROM $dailyQuoteTable ORDER BY id DESC LIMIT 1";
	}
}