<?php

class Cookie {

	public static function exists($name) {
		return (isset($_COOKIE[$name])) ? true : false;
	}
// returns if there is a cookie already set
	public static function get($name) {
		return $_COOKIE[$name];
	}

	public static function put($name, $value, $expiry) {
		if(setcookie($name, $value, time() + $expiry, '/')) {
			return true;
		}
		return false;
	}
// sets a new cookie
	public static function delete($name) {
		self::put($name, '', time() - 1);
	}
// deletes a cookie
}

?>
