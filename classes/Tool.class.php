<?php
class Tool {
	function __construct(){
	}
	
	function __destruct(){
	}
	
	static function &getBaseObject($class, $id) {
		global $cache;
		var_dump($cache);
		
		// Reset cache.
		$count = count($cache, COUNT_RECURSIVE)%5000;
		if(count($cache) > 0 && $count == 0){
			unset($cache);
		}
		
		// Initialize cache.
		if(is_null($cache)) {
			$cache = array();
		}
		
		if(! isset($cache[$class][$id])) {
			// Object is not in cache, put it in.
			$cache[$class][$id] = new $class($id);
		}			
		// var_dump($cache);
		return $cache[$class][$id];
	}
}

?>