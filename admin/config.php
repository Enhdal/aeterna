﻿<?php
	// Autoload function.
	define('CLASS_DIR', 'classes/');
    set_include_path(get_include_path().PATH_SEPARATOR.CLASS_DIR);
	
	spl_autoload_extensions('.class.php');
	spl_autoload_register();
		
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
	
	// Function to log in files.
	function _log($value, $file = 'default_logs.log'){
		file_put_contents($file, "=================== Log starts at ".date('Y-m-d H:i:s')."==================== \n", FILE_APPEND | LOCK_EX);
		file_put_contents($file, print_r($value, true), FILE_APPEND | LOCK_EX);
		file_put_contents($file, "=================== Log ends at ".date('Y-m-d H:i:s')."==================== \n", FILE_APPEND | LOCK_EX);
	}
	
	$cfg = array();
	$cache = array();
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
	
	$GLOBALS['db'] = '';
	$GLOBALS['cfg'] = $cfg;
	$GLOBALS['cache'] = $cache;
?>