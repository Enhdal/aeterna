<?php
	// Autoload function.
	/*spl_autoload_register(function ($class) {
		$path = 'http://localhost/aeterna/inclure/';
		require_once $path.'class.'.ucfirst($class).'.php';
	});*/
	define('CLASS_DIR', 'classes/');
    set_include_path(get_include_path().PATH_SEPARATOR.CLASS_DIR);
	
	spl_autoload_extensions('.class.php');
	spl_autoload_register();
	
	/**
	* Function to connect to the Database.
	*/
	function dbConnect(){
		$db = '';
		try {
			$db = new PDO('mysql:host=localhost;dbname=aeterna', 'root', 'B1r8o9o8d', array(PDO::ATTR_PERSISTENT => true));
			$GLOBALS['db'] = $db;
		} catch (Exception $e) {
			die('Error : ' . $e->getMessage());
		}
	}
	
	/**
	* Create a random string.
	* @param	int	$length	The length of the random string.
	*/
	/*function randStr($length){
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ./';
		$randstring = '';
		for ($i = 0; $i < $length; $i++) {
			$randstring = $characters[rand(0, strlen($characters))];
		}
		return $randstring;
	}*/
	
	$cfg = array();
	$error_code = array();
	
	
	// Table user.
	$cfg['user'] = array(
		'fields' => array(
			'id_user' => 'int',
			'login' => 'char',
			'password' => 'char',
			'email' => 'char',
			'modif_right' => 'boolean',
			'admin_right' => 'boolean',
			'admin' => 'boolean',
			'active' => 'boolean'
		)
	);
	
	// Table group.
	$cfg['group'] = array(
		'fields' => array(
			'id_group' => 'int',
			'title' => 'char',
			'rights' => 'int'
		)
	);
	
	
	// Table link_user_object.
	$cfg['link_user_object'] = array(
		'fields' => array(
			'id_link_user_object' => 'int',
			'id_user' => 'int',
			'obj_table' => 'varchar',
			'obj_id' => 'int'
		)
	);
	
	// Table chapter.
	$cfg['chapter'] = array(
		'fields' => array(
			'id_chapter' => 'int',
			'obj_created_time' => 'timestamp',
			'obj_updated_time' => 'timestamp',
			'title' => 'varchar',
			'content' => 'text',
			//'author' => 'int',
			'validation_waiting' => 'boolean',
			'published' => 'boolean',
			'validated' => 'boolean',
			'validated_by' => 'int'
		)
	);
	
	// Table chapter.
	$cfg['book'] = array(
		'fields' => array(
			'id_book' => 'int',
			'obj_created_time' => 'timestamp',
			'obj_updated_time' => 'timestamp',
			'title' => 'varchar',
			'content' => 'text',
			//'author' => 'int',
			'validation_waiting' => 'boolean',
			'published' => 'boolean',
			'validated' => 'boolean',
			'validated_by' => 'int'
		)
	);
	
	// Table link_book_object.
	$cfg['link_book_object'] = array(
		'fields' => array(
			'id_link_book_object' => 'int',
			'id_book' => 'int',
			'obj_table' => 'varchar',
			'obj_id' => 'int'
		)
	);
	
	$GLOBALS['cfg'] = $cfg;
?>