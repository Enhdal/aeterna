<?php
	/*********************** Test nouvelle collection d'objets à ajouter. ************************/
	/*
	$users = new BaseObjectList();
	$user = new BaseObject('user');
	$user->login = 'test1';
	$users->push($user);
	$user = new BaseObject('user');
	$user->login = 'test2';
	$users->push($user);
	$user = new BaseObject('user');
	$user->login = 'test3';
	$users->push($user);
	$user = new BaseObject('user');
	$user->login = 'test4';
	$users->push($user);
	$user = new BaseObject('user');
	$user->login = 'test5';
	$users->push($user);
	
	$users->addAll();
	$users->seek(0);
	while($user = $users->getNext())
		echo $user->id_user.'<br />';
		
	*/
	
	/*********************** Test collection d'objets à supprimer. ************************/
	/*$users = new BaseObjectList('user', '', 'id_user > 10');
	while($user = $users->getNext())
		echo $user->id_user.'<br />';
		
	$users->deleteAll();*/
	
	$books = new BaseObjectList('book');
	while($book = $books->getNext())
		echo $book->title.'<br />';
		
	$user = Tool::getBaseObject('User', 1);
	echo $user->login.'<br />';
	
	$book = Tool::getBaseObject('Book', 5);
	$book = Tool::getBaseObject('Book', 6);
	echo $book->title.'<br />';
?>