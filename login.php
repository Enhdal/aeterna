<?php
	session_start();
	$user_id = (int)$_SESSION['user_id'];
	$login = (string)$_SESSION['login'];

	if($user_id == 0){
	
?>
		<form id="user_connect">
			<table>
				<tr>
					<td>Login:</td>
					<td><input type="text" size="20" name="login" value="" / ></td>
				</tr>
				<tr>
					<td>Mot de passe:</td>
					<td><input type="password" size="20" name="password" value="" / ></td>
				</tr>
			</table>
			<span id="connection" class="ui-btn">Se connecter</span>
		</form>
<?php
	} else {
?>
		<div style="text-align:center;">
			Bonjour <?=$login;?> !
		</div>
<?php
	}
	//session_destroy();
?>