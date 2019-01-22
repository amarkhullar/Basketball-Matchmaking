<?php

class Token {

	public static function generate() {
		return Session::put(Config::get('session/token_name'), md5(uniqid()));
	}
// generates a token with the token name stored in config
	public static function check($token) {
		$tokenName = Config::get('session/token_name');

		if(Session::exists($tokenName) && $token === Session::get($tokenName)) {
			Session::delete($tokenName);
			return true;
		}
// if the existing session is the same as the session that is meant to be there then it deletes the stored token name and returns true
		return false;
// if the session token is different from the stored token it returns false, this is used so that cross site request forgery can be prevented, so data cannot be inputted in the url bar
	}
}


?>
