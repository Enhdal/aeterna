<header>
	<h1 style="text-align:center;">Dernières actualités.</h1>
	<hr />
</header> 
<?php
	$articles = new BaseObjectList('article', '', 'validated = 1 AND published = 1', 'obj_created_time DESC', '0, 5');
	while($article = $articles->getNext()){
?>
		<article class="article">
			<h3><?=$article->title;?></h3>
			<div class="article_content">
				<?=$article->content;?>
			</div>
			<div class="author_info">
				<?php
					$user = Tool::getBaseObject('User', $article->author);
					
					$tmp = explode(' ', $article->obj_created_time);
					$date = explode('-', $tmp[0]);
					$time = explode(':', $tmp[1]);
					
					echo 'Posté par '.$user->login.', le '.date('d/m/Y', mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]));
				?>
			</div>
		</article>
<?php
	}
?>

<footer>

</footer>