<?php
	include "ajout.inc.php";
	
	enTete("Accueil");
	?>
		
		<div id="Menu">
			<form method="post" action="connection.php">
				<table>
					<tr>
						<td> Login </td>
						<td> <input name="login"></td>
						<td> Mot de passe </td>
						<td> <input type="password" name="password"> </td>
						<td> <input type="submit" value="Connexion"> </td>
						<td> <span style="font-size:10px;"> <a href="inscription.php"> Inscription </span></td>
					</tr>
				</table>
			</form>				
		</div>
		
		
		
<?php
	pied();
?>