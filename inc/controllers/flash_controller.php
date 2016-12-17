<?php

/**
* Used to organize reading and writing data from session
* for flash messages
*/
class FlashController{
	const FLASH_SUCCESS = 0;
	const FLASH_WARNING = 1;
	const FLASH_ERROR = 2;

	//stores message in session for flash messages
	//$infoLevel 
	public static function setFlash(string $message, int $infoLevel){
		$_SESSION['flash_message'] = array($infoLevel => $message);
	}

	//if flash message is set returns array where infolevel is key and message is value
	//if no message returns false
	//will delete message after retrieval so flash message is only displayed once
	public static function getFlash(){
		if(isset($_SESSION['flash_message'])){
			$ret = $_SESSION['flash_message'];
			//delete from session so message only displayed once
			unset($_SESSION['flash_message']);
			return $ret;
		}
		return false;
	}
	//returns appropriate css class for given flash infoleve/
	public static function getFlashClass(int $infoLevel): string{
		if($infoLevel === self::FLASH_SUCCESS){
			return 'success';
		}
		if($infoLevel === self::FLASH_WARNING){
			return 'warning';
		}
		return 'error';
	}

}