<?php

class Session {

	public static function exists($name) {
		return (isset($_SESSION[$name])) ? true : false;
	}
	// checks if session exists
	public static function put($name, $value) {
		return $_SESSION[$name] = $value;
	}
	//starts a session
	public static function get($name) {
		return $_SESSION[$name];
	}
	//gets the name of the user of the session
	public static function delete($name) {
		if(self::exists($name)) {
			unset($_SESSION[$name]);
		}
	}
	// deletes a session
	public static function flash($name, $string = '') {
		if(self::exists($name)) {
			$session = self::get($name);
			self::delete($name);
			return $session;
		} else {
			self::put($name, $string);
		}
	}
	// used put a message on a screen, then delete the message after
	// for flash messages
}

?>