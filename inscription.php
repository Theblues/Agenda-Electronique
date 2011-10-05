<?php
	include "ajout.inc.php";
	
	enTete("Inscription");
	?>
		
		
		<div id="Inscription">
			<span style="font-size:20px; text-align: center;"><p>Veuillez vous inscrire</p></h2></span>
			<form method="post" action="inscription.php">
				<table>
					<tbody><tr>
						<td>Login</td>
						<td><input type="text" name="login"></td>
					</tr>
					<tr>
						<td>Choisir un mot de passe</td>
						<td><input type="password" name="password"></td>
					</tr>
					<tr>
						<td>Verification mot de passe</td>
						<td><input type="password" name="validation"></td>
					</tr>
					<tr>
						<td> Email </td>
						<td><input type="text" name="email"></td>
					</tr>
					<tr>
						<td></td>
						<td> <input type="reset" value="Effacer"><input type="submit" value="OK" style="margin-left:30px;"></td>
					</tr>
					</tbody>
				</table>
			</form>
		</div>
		
<?php

	if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['validation']) && isset($_POST['email']) )
	{
		if (!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['validation']) && !empty($_POST['email']) )
		{
			$login = $_POST['login'];
			$password = $_POST['password'];
			$validation = $_POST['validation'];
			$email = $_POST['email'];
			
			if ($password == $validation)
			{
				$taillepassword = strlen($password);
				if ($taillepassword > 4)
				{
					
				}
				else
					echo erreur('mdpcourt');
			}
			else
				echo erreur('verif');
		}
		else
			erreur('pasrempli');
	}
	pied()
?>