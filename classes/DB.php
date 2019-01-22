<?php

class DB {
	private static $_instance = null;
	private $_pdo,
			$_query,
			$_error = false,
			$_results,
			$_count = 0;
// setting variables that I will need
	private function __construct() {
		try {
			$this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . config::get('mysql/db'), config::get('mysql/username'), config::get('mysql/password'));
		} catch(PDOException $e) {
			die($e->getMessage());
		}
	}
// Connects to database, uses database values from config
	public static function getInstance() {
		if(!isset(self::$_instance)){
			self::$_instance = new DB();
		}
		return self::$_instance;
	}
// Creates an instance, only as long as it is not already instantiated
	public function query($sql, $params = array()) {
		$this->_error = false;
		if($this->_query = $this->_pdo->prepare($sql)) {
			$x = 1;
			if(count($params)){
				foreach($params as $param) {
					$this->_query->bindValue($x, $param);
					$x++;
				}
			}
			if($this->_query->execute()) {
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
				$this->_count = $this->_query->rowCount();
			}	else {
					$this->_error = true;

			}
		}
		return $this;
	}
// Skeleton for queries. Checks if any errors in SQL, if all SQL is fine it executes the query and stores the values from database into variables in this class.
	public function action($action, $table, $where = array()) {
		if(count($where) ===3) {
			$operators = array('=', '>', '<', '>=', '<=');

			$field = $where[0];
			$operator = $where[1];
			$value = $where[2];

			if(in_array($operator, $operators)){
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
				if(!$this->query($sql, array($value))->error()) {
					return $this;
				}
			}
		}
		return false;
	}
	// the backbone for the other queries, has a skeleton for all queries where any operator, function, and variable can be used
	public function get($table, $where){
		return $this->action('SELECT *', $table, $where);
	}
	// used to select data from database, using action function
	public function delete($table, $where){
		return $this->action('DELETE', $table, $where);
	}
	// used to delete data from database, using action function

	public function insert($table, $fields = array()) {
		if(count($fields)) {
			$keys = array_keys($fields);
			$values = null;
			$x = 1;

			foreach($fields as $field){
				$values .= '?';
				if($x < count($fields)){
					$values .= ', ';
				}
				$x++;
			}

			$sql = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`) VALUES ({$values})";

			if(!$this->query($sql, $fields)->error()) {
				return true;
			}
		}
		return false;
	}
// Used as a skeleton to create INSERT queries. Very useful, can be reused for any INSERT queries throughout the website. 
	public function update($table, $id, $fields) {
		$set = '';
		$x = 1;

		foreach($fields as $name => $value) {
			$set .= "{$name} = ?";
			if($x < count($fields)) {
				$set .= ',';
			}
			$x++;
		}

		$sql ="UPDATE {$table} SET {$set} WHERE id = {$id}";

		if(!$this->query($sql, $fields)->error()) {
			return true;
		}
		return false;
	}
// Skeleton for UPDATE queries.
	public function results() {
		return $this->_results;
	}

	public function first() {
		return $this->results()[0];
	}
// returns the first result, mainly used if only one result
	public function error() {
		return $this->_error;
	}
	// these functions are used for the queries

	public function count() {
		return $this->_count;
	}
	//returns the number of results
}
?>