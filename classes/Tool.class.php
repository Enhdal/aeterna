<?php
class Tool {
	function __construct(){
	}
	
	function __destruct(){
	}
	
	/**
	* Checks cache if the object already exists and returns it
	* else instantiates the object and saves it in cache.
	* @param	$class	Class to instantiate, class name have to be writen with first character in uppercase.
	* @param	$id	Id of the object in database.
	* @param	$row	The data got back in database.
	* @return	$cache[$class][$id]	Object in cache.
	*/
	static function &getBaseObject($class, $id, $row = null) {
		global $cache;
		
		// Initialize cache.
		if(is_null($cache)) {
			$cache = array();
		}
		
		if(! isset($cache[$class][$id])) {
			// Object is not in cache, put it in.
			$cache[$class][$id] = new $class($id, false, $row);
		}
		//_log($cache, 'Tool.class.getBaseObject.log');
		return $cache[$class][$id];
	}
	
	/**
	* Connect to database.
	*/
	static function dbConnect(){
		global $db;
		$dbname = '';
		$login = '';
		$pass = '';
		try {
			$db = new PDO('mysql:host=localhost;dbname=aeterna', 'root', 'B1r8o9o8d', array(PDO::ATTR_PERSISTENT => true));
		} catch (Exception $e) {
			die('Error : ' . $e->getMessage());
		}
	}
}

?>