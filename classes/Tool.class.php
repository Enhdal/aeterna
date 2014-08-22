<?php
class Tool {
	function __construct(){
	}
	
	function __destruct(){
	}
	
	static function &getBaseObject($class, $id) {
		global $cache;
		
		// Initialize cache.
		if(is_null($cache)) {
			$cache = array();
		}
		
		if(! isset($cache[$class][$id])) {
			// Object is not in cache, put it in.
			$cache[$class][$id] = new $class($id);
		}			
		//var_dump($cache);
		return $cache[$class][$id];
	}
	
	static function dbConnect(){
		$db = '';
		$dbname = '';
		$login = '';
		$pass = '';
		try {
			$db = new PDO('mysql:host=localhost;dbname=aeterna', 'root', 'B1r8o9o8d', array(PDO::ATTR_PERSISTENT => true));
			$GLOBALS['db'] = $db;
		} catch (Exception $e) {
			die('Error : ' . $e->getMessage());
		}
	}
}

?>