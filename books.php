<?php /*
<div>
	<select>
		<?=Tool::getOption('book', 'title', 'id_book', $where);?>
	</select>
</div>
*/?>
<?php
	$books = new BaseObjectList('book', 'INNER JOIN link_user_object luo ON b.id_book = luo.obj_id AND luo.obj_table = "book"', '', '', '', 'b');
	while($book = $books->getNext()){
?>
<article class="book_list">
		<span class="book_title"><?=$book->title;?></span>
		<div>
<?php		
		//echo $book->title.'<br />';
		
		$id_book = $book->id_book;
		$chapters = new BaseObjectList('chapter', 'INNER JOIN link_book_object lbo ON c.id_chapter = lbo.obj_id AND lbo.obj_table = "chapter"', 'lbo.id_book = '.$id_book, '', '', 'c');
		while($chapter = $chapters->getNext()){
?>
			<span class="chapter_title"><?=$chapter->title;?></span>
<?php
			//echo $chapter->title.'<br />';
		}
?>
	</div>
</article>
<?php
	}
?>