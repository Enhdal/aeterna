<div id="connec">
	<?php
		if(!$_SESSION['login']){
		?>
			<form action="./register/login.php" method="post">
				<table>
					<tr>
						<td>Login:</td>
						<td><input type="text" size="6" name="login"/> </td> 
					</tr>
					<tr>
						<td>Pass:</td>
						<td><input type="password" size="6" name="pass"/> </td> 
					</tr>
					<tr>
						<td><input type="submit" value="Valider"/></td>
					</tr>
				</table>
			</form>
		<?php
		}
		if($_SESSION['login']){
		?>
			<table>
				<td>Bienvenue <?php	echo $_SESSION['login']; ?> </td>
				<form action="./admin/deconnection.php" method="post">
					<tr><td><input type="submit"  value="Se deconnecter"/> </td> </tr>
				</form>			
			</table>
		<?php
		}
		?>
</div>