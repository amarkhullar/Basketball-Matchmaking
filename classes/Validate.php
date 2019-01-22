<?php

class Validate {

	private $_passed = false,
			$_errors = array(),
			$_db = null;

	public function __construct() {

		$this->_db = DB::getInstance();

	}
//constructor
	public function check($source, $items = array()) {

		foreach($items as $item => $rules) {
			foreach($rules as $rule => $rule_value) {
				
				$value = $source[$item];

				if($rule === 'required' && empty($value)) {
					$this->addError("{$item} is required.");
				} else if(!empty($value)) {
					switch($rule) {
						case 'min':
							if(strlen($value) < $rule_value) {
								$this->addError("{$item} must be a minimum of {$rule_value} characters.");
							}
						break;
						case 'max':
							if(strlen($value) > $rule_value) {
								$this->addError("{$item} must be less than {$rule_value} characters.");
							}
						break;
						case 'matches':
							if($value != $source[$rule_value]) {
								$this->addError("{$rule_value} must match {$item}.");
							}
						break;
						case 'unique':
							$check = $this->_db->get($rule_value, array($item,'=', $value));
							if($check->count()) {
								$this->addError("{$item} already exists.");
							}
						break;
						case 'minvalue':
							if($value < $rule_value) {
								$this->addError("{$item} must be greater than or equal to {$rule_value}.");
							}
						break;
						case 'maxvalue':
							if($value > $rule_value) {
								$this->addError("{$item} must be less than or equal to {$rule_value}.");
							}
						break;
					}
				}
			}
		}
		if(empty($this->_errors)) {
			$this->_passed = true;
		}
		return $this;
	}
//Checks the data against the validation rules to determine whether it passed, and if not it creates a list of errors
	private function addError($error) {
		$this->_errors[] = $error;
	}
//adds an error to the error list
	public function errors() {
		return $this->_errors;
	}
//returns the error list
	public function passed() {
		return $this->_passed;
	}
//returns if the data passed the validation check or not
}
