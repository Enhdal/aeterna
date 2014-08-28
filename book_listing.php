<?php
	session_start();
	$id_author = (int)$_SESSION['user_id'];
	$where = '';
	if($id_author > 0)
		$where = 'luo.id_user = '.$id_author;
		
	$books = new BaseObjectList('book', 'INNER JOIN link_user_object luo ON b.id_book = luo.obj_id AND luo.obj_table = "book"', $where, '', '', 'b');
	while($book = $books->getNext()){
		
		echo $book->title.'<br />';
		
		$id_book = $book->id_book;
		$chapters = new BaseObjectList('chapter', 'INNER JOIN link_book_object lbo ON c.id_chapter = lbo.obj_id AND lbo.obj_table = "chapter"', 'lbo.id_book = '.$id_book, '', '', 'c');
		while($chapter = $chapters->getNext()){
			echo $chapter->title.'<br />';
		}
	}

?>