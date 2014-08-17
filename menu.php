<ul id="menu">
	<li class="menu"><a href="index.php"><span class="ui-btn">Accueil</span></a></li>
	<li class="menu" id="menu_histoire"><span class="ui-btn">Histoire</span>
		<ul class="submenu" style="display:none;">
			<li><span class="ui-btn menu_choice" x-page="histoire">Histoire principale</span></li>
			<li><span class="ui-btn menu_choice" x-page="histoire_hs">Hors Série</span></li>
		</ul>
	</li>
	<li class="menu" id="menu_info"><span class="ui-btn">Informations</span>
		<ul class="submenu" style="display:none;">
			<li><span class="ui-btn menu_choice" x-page="races">Races</span></li>
			<li><span class="ui-btn menu_choice" x-page="personnages">Personnages</span></li>
			<li><span class="ui-btn menu_choice" x-page="bestiaire">Bestiaire</span></li>
			<li><span class="ui-btn menu_choice" x-page="lieux">Lieux</span></li>
		</ul>
	</li>
	<?php
		if((int)$_SESSION['user_id'] == 0){
	?>
		<li class="menu menu_choice" x-page="signup" ><span class="ui-btn">S'inscrire</span></li>
	<?php
		}
	?>
	<li><button id="openPanel" class="ui-btn ui-corner-all ui-shadow ui-btn-icon-notext ui-icon-carat-l">&nbsp;</button></li>
</ul>