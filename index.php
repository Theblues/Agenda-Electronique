<?php
	include "ajout.inc.php";
	include "string.inc.php";
	include "calendrier.inc.php";
	
	enTete("Accueil");
	?>
		
		<div id="Menu">
			<form method="post" action="connection.php">
				<table class="Connection">
					<tr>
						<td> Login </td>
						<td> <input name="login"></td>
						<td> Mot de passe </td>
						<td> <input type="password" name="password"> </td>
						<td> <input type="submit" value="Connexion"> </td>
						<td> <a href="inscription.php"> Inscription </a></td>
					</tr>
				</table>
			</form>				
		</div>
<?php
		echo showCalendar(date("2011-09"));
		
	pied();
?>