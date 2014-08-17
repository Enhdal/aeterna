<?php
	session_start();
	include 'admin/config.php';
	$data = $_POST['data'];
	$data = urldecode($data);
	$data = json_decode($data, true);
	//var_dump($data);
	$todo = $_POST['todo'];
	if(isset($todo)){
		//include 'connection.php';
		switch($todo){
			// Save a new user.
			case 'signup' : 
				$login = (string)$data['login'];
				$pwd = (string)$data['password'];
				$email = (string)$data['email'];
				$users = new BaseObjectList('user', '', "login = '$login' OR email = '$email'");
				//var_dump($users);
				//$count = $users->getCount();
				if(isset($login) && isset($pwd) && isset($email)){
					// Password encryption for security.
					$pwd = password_hash($pwd, PASSWORD_BCRYPT);
					if($user = $users->getNext()){
						echo 2;
					} else {
						$newuser = new BaseObject('user');
						$newuser->login = $login;
						$newuser->email = $email;
						$newuser->password = $pwd;
						$success = $newuser->add();
						
						echo $success;
					}
				}else{
					echo 0;
				}
				break;
			// Connect a user.
			case 'user_connect' :
				$login = $data['login'];
				$pass = $data['password'];
				$users = new BaseObjectList('user', '', "login = '$login'");
				if($user = $users->getNext()){
					$pwd_ok = password_verify($pass, $user->password);
					// Password is right, sign in.
					if($pwd_ok){
						// if password is right, save in session login, 
						// id of user and all groups where the user belongs to.
						if($user->active){
							$id_user = $user->id_user;
							// Look for any groups which contain this user.
							$groups = new BaseObjectList('link_user_object', '', "obj_table = 'group' AND obj_id = $id_user");
							$id_groups = array();
							// Get id for each group.
							while($group = $groups->getNext()){
								$id_groups[] = $group->id_group;
							}
							// Save data in session.
							$_SESSION['login'] = $login;
							$_SESSION['user_groups'] = $id_groups;
							$_SESSION['user_id'] = $id_user;
							//echo '<pre>'.print_r($_SESSION, true).'</pre>';
							echo (int)$pwd_ok;
						}else{
							// User is not active.
							echo 3;
						}
					}
				} else {
					// User doesn't exist.
					echo 2;
				}
				break;
			case 'add_chapter' : 
				// Create and add new object Chapter.
				$title = $data['title'];
				$content = $data['content'];
				$newchapter = new BaseObject('chapter');
				$newchapter->title = $title;
				$newchapter->content = $content;
				// Add new chapter object to database;
				$success = $newchapter->add();
				$id_chapter = $newchapter->id_chapter;
				// Create a link between an user and a chapter.
				$id_author = $data['id_author'];
				$newlink = new BaseObject('link_user_object');
				$newlink->id_user = $id_author;
				$newlink->obj_table = 'chapter';
				$newlink->obj_id = $id_chapter;
				// Add new link object to database;
				$success2 = $newlink->add();
				// Create a link between a book and the new chapter.
				$id_book = $data['id_book'];
				$newlink = new BaseObject('link_book_object');
				$newlink->id_book = $id_book;
				$newlink->obj_table = 'chapter';
				$newlink->obj_id = $id_chapter;
				// Add new link object to database;
				$success3 = $newlink->add();
				
				// Return result of adding new chapter and new link.
				// 0 means that one of adding has failed.
				// 1 means that each adding is a success.
				echo (int) ($success && $success2 && $success3);
				break;
			case 'update_chapter' :
				$title = $data['title'];
				$content = $data['content'];
				$id_author = $data['id_author'];
				$id_chapter = $data['id_chapter'];
				// Instanciate Chapter object from database.
				$chapter = new Chapter($id_chapter);
				// Change data.
				$chapter->title = $title;
				$chapter->content = $content;
				//$chapter->obj_updated_time = date('Y-m-d H:i:s');
				// Save new data in database.
				echo $chapter->update();
				break;
			case 'add_book' : 
				// Create and add new object Book.
				$title = $data['title'];
				$content = $data['content'];
				$newbook = new BaseObject('book');
				$newbook->title = $title;
				$newbook->content = $content;
				// Add new book object to database;
				$success = $newbook->add();
				$id_book = $newbook->id_book;
				// Create a link between an user and a book.
				$id_author = $data['id_author'];
				$newlink = new BaseObject('link_user_object');
				$newlink->id_user = $id_author;
				$newlink->obj_table = 'book';
				$newlink->obj_id = $id_book;
				// Add new link object to database;
				$success2 = $newlink->add();
				// Return result of adding new book and new link.
				// 0 means that one of adding has failed.
				// 1 means that both of adding is a success.
				echo (int) ($success && $success2);
				break;
			case 'update_book' :
				$title = $data['title'];
				$content = $data['content'];
				$id_author = $data['id_author'];
				$id_book = $data['id_book'];
				// Instanciate Book object from database.
				$book = new Book($id_book);
				// Change data.
				$book->title = $title;
				$book->content = $content;
				//$book->obj_updated_time = date('Y-m-d H:i:s');
				// Save new data in database.
				echo $book->update();
				break;
			case 'add_author' : 
			
				break;
			default : 
				echo 'Error : Case '.$todo.' not found !';
				break;
		}
	}
?>