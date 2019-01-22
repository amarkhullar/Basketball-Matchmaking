<?php

class Input {

	public static function exists($type = 'post') {
		switch($type) {
			case 'post':
				return(!empty($_POST)) ? true : false;
			break;
			case 'get':
				return (!empty($_POST)) ? true : false;
			break;
			default:
				return false;
			break;
		}
	}
//check if there has been an input by the user
	public static function get($item) {
		if(isset($_POST[$item])) {
			return $_POST[$item];
		} else if(isset($_GET[$item])) {
			return $_GET[$item];
		}
	return '';

	}
	//returns the input by the user, mainly used for login and registration
}
?>