﻿<!DOCTYPE html>
<?php 
session_start();
include './admin/config.php';
include './admin/connection.php';
?>
<html lang="fr">
	<head>
		<title>Bienvenue sur Aeterna</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!--[if lt IE 9]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
		<script src="javascript/jquery-2.1.1.min.js"></script>
		<script src="javascript/jquery.mobile-1.4.3.min.js"></script>
		<script src="javascript/jquery.json.min.js"></script>
		<script src="javascript/ckeditor/ckeditor.js"></script>
		<script src="javascript/aeterna.js"></script>
		<link rel="stylesheet" type="text/css" href="css/jquery.mobile-1.4.3.min.css" />
		<link rel="stylesheet" type="text/css" href="css/all.css" />
	</head>

	<body>
		<header class="mainHeader">
			<a href="index.php"><img src="images/test_ban.png"></img></a>
		</header>
		<nav class="mainMenu"><?php include('menu.php'); ?></nav>

		<section id='main' class="mainSection">
			<article id="mainContent" class="mainArticle">
				<?php if(isset($_GET['page'])) include($_GET['page'].'.php');?>
				&nbsp;
			</article>
			<aside id="rightPanel" class="contextPanel">
				<?php include('chapter_panel.php');?>
			</aside>
			
		</section>
		<footer class="mainFooter">footer</footer>
	</body>
</html>
<?php
//session_unset();
//session_destroy();
?>