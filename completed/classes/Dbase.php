<?php
class Dbase {

	private $_db_host = 'localhost';
	private $_db_name = '';
	private $_db_user = '';
	private $_db_password = '';
	
	private $_db_object = null;
	private $_db_driver_options = array();
	
	public $_last_statement;
	public $_affected_rows;
	public $_id;
	
	
	
	
	
	
	
	
	public function __construct() {
		$this->connect();
	}
	
	
	
	
	
	
	
	
	
	
	private function connect() {
		$this->setDriverOptions(array(
			PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
		));
		try {
			$this->_db_object = new PDO(
				"mysql:dbname={$this->_db_name};host={$this->_db_host}",
				$this->_db_user,
				$this->_db_password,
				$this->_driver_options
			);
		} catch (PDOException $e) {
			echo $e->getMessage();
			exit;
		}
	}
	
	
	
	
	
	
	
	
	public function setDriverOptions($options = null) {
		if (!empty($options)) {
			$this->_driver_options = $options;
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	private function query($sql = null, $params = null) {
		
		if (!empty($sql)) {
		
			$this->_last_statement = $sql;
			
			// check if connection is active and if not - start it
			if ($this->_db_object == null) {
				$this->connect();
			}
			
			try {
			
				$statement = $this->_db_object->prepare($sql, $this->_driver_options);
				
				$params = Helper::makeArray($params);
				
				if (!$statement->execute($params) || $statement->errorCode() != '00000') {
					$error = $statement->errorInfo();
					throw new PDOException("Database error [{$error[0]}]: {$error[2]}, driver error code is {$error[1]}");
					exit;
				}
				
				return $statement;
				
			
			} catch (PDOException $e) {
				echo $this->formatException($e);
				exit;
			}
		
		}
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	public function formatException($exception = null) {
		if (is_object($exception)) {
			$out = array();
			$out[] = '<strong>Message:</strong> '.$exception->getMessage();
			$out[] = '<strong>Code:</strong> '.$exception->getCode();
			$out[] = '<strong>File:</strong> '.$exception->getFile();
			$out[] = '<strong>Line:</strong> '.$exception->getLine();
			$out[] = '<strong>Trace:</strong> '.$exception->getTraceAsString();
			$out[] = '<strong>Last statement:</strong> '.$this->_last_statement;
			return '<p>'.implode('<br />', $out).'</p>';
		}
	}
	
	
	
	
	
	public function getLastInsertId($sequenceName = null) {
		return $this->_db_object->lastInsertId($sequenceName);
	}
	
	
	
	
	
	
	
	
	
	
	
	public function getAll($sql = null, $params = null) {
		if (!empty($sql)) {
			$statement = $this->query($sql, $params);
			return $statement->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	
	
	
	
	
	
	
	
	
	public function getOne($sql = null, $params = null) {
		if (!empty($sql)) {
			$statement = $this->query($sql, $params);
			return $statement->fetch(PDO::FETCH_ASSOC);
		}
	}
	
	
	
	
	
	
	
	
	
	
	public function execute($sql = null, $params = null) {
		if (!empty($sql)) {
			$statement = $this->query($sql, $params);
			$this->_affected_rows = $statement->rowCount();
			return true;
		}
		return false;
	}
	
	
	
	
	
	
	
	
	
	
	public function insert($sql = null, $params = null) {
		if (!empty($sql)) {
			if ($this->execute($sql, $params)) {
				$this->_id = $this->getLastInsertId();
				return true;
			}
			return false;
		}
		return false;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	





}