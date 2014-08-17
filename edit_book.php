<?php
	$id_author = (int)$_SESSION['user_id'];
	$user = new User($id_author);
	if($user->admin == 0)
		die('Error : Forbidden page !');
	$id_book = (int)$_GET['id_book'];
	if($id_book > 0){
		$book = new Book($id_book);
?>
		<form name="edit_book" id="book_form">

<?php
	} else {
?>
		<form name="add_book" id="book_form">
<?php
	}
?>
	<table>
		<tr>
			<td><span>Titre :</span></td>
			<td><input type="text" size="100" name="title" value="<?php echo html_entity_decode($book->title);?>" /></td>
		</tr>
		<tr>
			<td style="vertical-align:top;"><span>Synopsis :</span></td>
			<td><textarea class="ckeditor" name="content" height="300px;"><?php echo html_entity_decode($book->content);?></textarea></td>
		</tr>
		<tr style="display:none;">
			<?php
				if($id_book > 0){
			?>
			<td><input type="text" size="20" name="id_book" value="<?=$id_book;?>" /></td>
			<?php
				}
			?>
			<td><input type="text" size="20" name="id_author" value="<?=$_SESSION['user_id'];?>" /></td>
		</tr>
		<tr>
			<td></td>
			<td><span id="book_btn" class="ui-btn" style="width:100px;float:right;" onClick="$(this).closest('form#book_form').setBook(<?=$id_book;?>)">Enregistrer</span></td>
		</tr>
	</table>
</form>

<script>
	initPage();
</script>