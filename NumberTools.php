<?php
/**
 *  NumberTools Class
 * 	Author Pouya Darabi
 *	Contact  : Pouyyadrabi@gmail.com
 */
 
class NumberTools {
	private static $persian_digits = array (
			'۰',
			'۱',
			'۲',
			'۳',
			'۴',
			'۵',
			'۶',
			'۷',
			'۸',
			'۹' 
	);
	private static $arabic_digits = array (
			'٠',
			'١',
			'٢',
			'٣',
			'٤',
			'٥',
			'٦',
			'٧',
			'٨',
			'٩' 
	);
	private static $english_digits = array (
			'0',
			'1',
			'2',
			'3',
			'4',
			'5',
			'6',
			'7',
			'8',
			'9' 
	);
	public static function arabicPersionToEnglish($str) {
		$str = str_replace ( self::$persian_digits, self::$english_digits, $str );	
		$str = str_replace ( self::$arabic_digits, self::$english_digits, $str );
		return $str;
	}  
	public static function EnglishToPersion($str) {
		return str_replace ( self::$english_digits, self::$persian_digits, $str );	
	}  
	
	public static function EnglishToarabic($str) {
		return str_replace ( self::$english_digits, self::$arabic_digits, $str );	
	}  


}
