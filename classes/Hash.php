<?php

class Hash {

	public static function make($string, $salt = '') {
		return hash('sha256', $string . $salt);
	}
// Uses the SHA256 method to turn the string provided into a hash
	public static function salt($length) {
		return mcrypt_create_iv($length);
	}

	public static function unique() {
		return self::make(uniqid());
	}

}

?>