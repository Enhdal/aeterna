<?php
	$id_author = (int)$_SESSION['user_id'];
	if($id_author > 0){
		$user = new User($id_author);
		if($user->admin == 0)
			die('Error : Forbidden page !');
		$id_chapter = (int)$_GET['id_chapter'];
		if($id_chapter > 0){
			$chapter = new Chapter($id_chapter);
?>
			<form name="edit_chapter" id="chapter_form">

<?php
		} else {
?>
			<form name="add_chapter" id="chapter_form">
<?php
		}
?>
	<table>
		<tr>
			<td><span>Titre :</span></td>
			<td><input type="text" size="100" name="title" value="<?php echo html_entity_decode($chapter->title);?>" /></td>
		</tr>
		<tr>
			<td style="vertical-align:top;"><span>Contenu :</span></td>
			<td><textarea class="ckeditor" name="content" height="300px;"><?php echo html_entity_decode($chapter->content);?></textarea></td>
		</tr>
		<tr style="display:none;">
			<?php
				if($id_chapter > 0){
			?>
			<td><input type="text" size="20" name="id_chapter" value="<?=$id_chapter;?>" /></td>
			<?php
				}
			?>
			<td><input type="text" size="20" name="id_author" value="<?=$_SESSION['user_id'];?>" /></td>
		</tr>
		<?php
			// If it's a new chapter to add, select the book to link it.
			if($id_chapter == 0){
		?>
				<tr>
					<td>
						<select name="id_book">
							<?php
								$books = new BaseObjectList('book', 'INNER JOIN link_user_object luo ON b.id_book = luo.obj_id AND luo.obj_table = "book"', 'luo.id_user = '.$id_author, '', '', 'b');
								while($book = $books->getNext()){
							?>
								<option value="<?=$book->id_book;?>"><?=$book->title;?></option>
							<?php
								}
							?>
						</select>
					</td>
				</tr>
		<?php
			}
		?>
		<tr>
			<td></td>
			<td><span id="chapter_btn" class="ui-btn" style="width:100px;float:right;" onClick="$(this).closest('form#chapter_form').setChapter(<?=$id_chapter;?>)">Enregistrer</span></td>
		</tr>
	</table>
</form>

<script>
	initPage();
</script>
<?php
	}
?>