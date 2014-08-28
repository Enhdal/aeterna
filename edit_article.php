<?php
	$id_author = (int)$_SESSION['user_id'];
	if($id_author > 0){
		$user = new User($id_author);
		if($user->admin == 0)
			die('Error : Forbidden page !');
		$id_article = (int)$_GET['id_article'];
		if($id_article > 0){
			$article = new Article($id_article);
?>
			<form name="edit_article" id="article_form">

<?php
		} else {
?>
			<form name="add_article" id="article_form">
<?php
		}
?>
	<table>
		<tr>
			<td><span>Titre :</span></td>
			<td><input type="text" size="100" name="title" value="<?php echo html_entity_decode($article->title);?>" /></td>
		</tr>
		<tr>
			<td style="vertical-align:top;"><span>Contenu :</span></td>
			<td><textarea class="ckeditor" name="content" height="300px;"><?php echo html_entity_decode($article->content);?></textarea></td>
		</tr>
		<tr style="display:none;">
			<?php
				if($id_article > 0){
			?>
			<td><input type="text" size="20" name="id_article" value="<?=$id_article;?>" /></td>
			<?php
				}
			?>
			<td><input type="text" size="20" name="id_author" value="<?=$id_author;?>" /></td>
		</tr>
		<tr>
			<td></td>
			<td><span id="article_btn" class="ui-btn" style="width:100px;float:right;" onClick="$(this).closest('form#article_form').setArticle(<?=$id_article;?>)">Enregistrer</span></td>
		</tr>
	</table>
</form>

<script>
	initPage();
</script>
<?php
	}
?>