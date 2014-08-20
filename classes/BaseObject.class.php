<?php

Class BaseObject {
	private $data = array();
	private $dataOld = array();
	private $loaded = false;
	private $dataOldString = '';
	
	protected $_table = '';
	protected $_id = 0;
	
	
	public function __construct($t, $i = 0) {
		global $cfg;
		$table = $this->_table;
		// Test if table exist
		//echo '<pre>'.print_r($cfg, true).'</pre>';
		if(! isset($cfg[$t]))
			die('ERROR 20140710.01 table '.$t.' doesn\'t exist');
		$this->_table = $t;
		// Test if $i is integer
		if(! is_numeric($i) && $i != '') {
			die('ERROR 20140710.02 bad id');
		}
		$this->_id = (int) $i;
		dbConnect();
    }
	
	public function isLoaded() {
		return $this->loaded && (count($this->data) > 0);
    }
	
	// Load object from db row.
	protected function loadFromRow($row = null) {
		if(is_null($row))
			die('ERROR 20140710.03 - No data for loading function.');

		foreach($row as $field => $val) {
			$this->data[$field] = $val;
		}
		$this->dataOld = $this->data;
		$s = '';
		if(!is_null($this->dataOld) && !empty($this->dataOld)){
			foreach($this->dataOld as $field=>$value){
				$s .= $value;
			}
		} else {
			$s = '';
		}
		// String to check updating data.
		$this->dataOldString = md5($s);
		$this->loaded = true;
	}
	
	public function loadFromDb($error = true) {
		global $cfg;
		global $db;
		$_table = $this->_table;
		$_id = $this->_id;
		
		$q = '';
		foreach($cfg[$_table]['fields'] as $field => $type) {
			if($q != '') {
				$q .= ',';
			}
			$q .= strtolower($field);
		}
		
		// Query.
		$q = "SELECT $q FROM $_table WHERE id_$_table=$_id";
		try {
			$answer = $db->query($q);
			$row = $answer->fetch(PDO::FETCH_ASSOC);
			
			if(count($row) == 0 || ! $row) {
				if($error) {
					$log = 'BaseObject - loadFromDb() Failed, no data, q=['.$q.'], mysql_errno=['.mysql_errno().'], mysql_error=['.mysql_error().']';
					echo $log;
					// Error log.
					file_put_contents('BaseObject_loadFromDb_error.log', $log . "\n" . print_r(debug_backtrace(), true));
				}
				return false;
			} else {
				// Loads data.
				$this->loadFromRow($row);
				return true;
			}
			
			$answer->closeCursor();
		} catch(Exception $ex) {
			dbConnect();
			$this->loadFromDb($error);
		}
	}
	
	// Update object to database.
	public function update() {
		global $db;
		//dbConnect();
		$_table = $this->_table;
		$_id = $this->_id;
		
		// Tests if data have been updated. md5 on data.
		$s = '';
		foreach($this->data as $field=>$value){
			$s .= $value;
		}
		$s = md5($s);
		
		// Compare two md5 from old and new data to check if data have changed.
		if($this->dataOldString != $s){
			$q .= '';
			foreach($this->data as $field=>$value){
				if($q != '')
					$q .= ',';
				$q .= " $field = '$value'";
			}
			try {
				$query = $db->prepare('UPDATE '.$_table.' SET '.$q.' WHERE id_'.$_table.' = '.$_id);
				$query->execute($this->data);
				return 1;
			}catch(Exception $ex) {
				// If connexion to database doesn't work, reconnects to database.
				//dbConnect();
				// Starts again the updating function.
				//$this->update();
			}
		}

		return 0;
	}
	
	/*
	* Add object to database.
	*/
	public function add(){
		global $db;
		//dbConnect();
		$_table = $this->_table;
		$_id = $this->_id;
		$q = $q2 = '';
		foreach($this->data as $field=>$value){
			if($q != '')
				$q .= ',';
			$q .= " $field";
			
			if($q2 != '')
				$q2 .= ',';
			$q2 .= " :$field";
		}
		try {
			$req = $db->prepare("INSERT INTO $_table($q) VALUES($q2)");
			$req->execute($this->data);
			$this->data['id_'.$_table] = $_id = $db->lastInsertId();
			return 1;
		} catch(Exception $ex) {
			// If connexion to database doesn't work, reconnects to database.
			//dbConnect();
			// Starts again the adding function.
			//$this->add();
			return 0;
		}
	}
	
	// Delete object from database.
	public function delete(){
		global $db;
		//dbConnect();
		$_table = $this->_table;
		$_id = $this->_id;
		
		try {
			$db->exec("DELETE FROM $_table WHERE id_$_table=$_id");
			return 1;
		}catch(Exception $ex) {
			// If connexion to database doesn't work, reconnects to database.
			//dbConnect();
			// Starts again the deleting function.
			//$this->delete();
			return 0;
		}
	}
	
	// Universal setter.
	public function __set($name, $value) {
		global $cfg;
		if(! isset($this->data[$name])) {
			$type = $cfg[$this->_table]['fields'][$name];
			if(isset($cfg[$this->_table]['fields'][$name])) {
				$this->data[$name] = $value;
			} else {
				die('ERROR 20140711.01 ');
			}
		} else if((string) $this->data[$name] != (string) $value) {
			$this->data[$name] = $value;
		}
    }
	
	// Universal getter.
    public function __get($name) {
		global $cfg;
		
		$data = $this->data;
		if(substr($name, 0, 5) == '_old_') {
			$data = $this->dataOld;
			$name = substr($name, 5);
		}
		
		if (array_key_exists($name, $data)) {
			$type = $cfg[$this->_table]['fields'][$name];
			$val = $data[$name];
			if(substr($type, 0, 3) == 'int')
				$val = (int) $val;
			else if(substr($type, 0, 5) == 'float')
				$val = (float) $val;
			return $val;
		}
		
		$trace = debug_backtrace();
		trigger_error(
			'Propriété non-définie via __get(): ' . $name .
			' dans ' . $trace[0]['file'] .
			' à la ligne ' . $trace[0]['line'],
			E_USER_NOTICE);
		
		// Log l'erreur
		file_put_contents('dbobject_error__get.log', print_r(debug_backtrace(), true));
		return null;
	}

	/**
	 * isset($obj->a)
	 */
	public function __isset($name) {
		return isset($this->data[$name]);
	}

	/**
	 * unset($obj->a)
	 */
	public function __unset($name) {
		unset($this->data[$name]);
	}
}
?>