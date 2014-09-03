<!DOCTYPE html>
<?php 
session_start();
include './admin/config.php';
//include './admin/connection.php';
?>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bienvenue sur Aeterna</title>
	<script src="js/jquery-2.1.1.min.js"></script>
	<script src="js/jquery.json.min.js"></script>
	<script src="js/ckeditor/ckeditor.js"></script>
	<script src="js/aeterna.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/all.css" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
	<div class="container">
		<div class="page-header banner">
			<a href="index.php"><img class="img-responsive" src="images/test_ban.png"></img></a>
		</div>
		<nav class="navbar navbar-default" role="navigation">
			<div class="container-fluid">
				<ul class="nav navbar-nav">
					<li class="menu" id="menu_news"><a href="index.php?page=news">Accueil</a></li>
					<li class="menu" id="menu_book"><a href="index.php?page=books">Livres</a></li>
					<li class="menu" id="menu_admin"><a href="index.php?page=administration">Administration</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="menu"><a href="#"><span id="openPanel" class="glyphicon glyphicon-chevron-left"></span></a></li>
				</ul>
			</div>
		</nav>
		
		<section id='main' class="mainSection">
				
			<article id="mainContent" class="mainArticle">
				<?php if(isset($_GET['page'])) include($_GET['page'].'.php'); else include('news.php');?>
				&nbsp;
			</article>
			<article id="rightPanel" class="contextPanel">
				<?php include('chapter_panel.php');?>
			</article>
		</section>
		<footer class="mainFooter"><?php include('menu_footer.php');?></footer>
	</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>