<?php
	function enTete($title)
	{
		echo '<html>
			<head>
				<title> Index </title>
				<link rel="stylesheet" type="text/css" href="style.css" />
			</head>
			<body>
				<div id="site">
					<div id="header">'
						.$title.
					'</div>';
	}
	
	function pied()
	{
		echo '		<div id="footer">
						Footer
					</div>
				<div>
			</body>
			</html>';
	}
	
	function erreur($erreur)
	{
		echo '<div id ="erreur">';
		if ($erreur == 'verif')
			echo 'Les deux mots de passe sont différents';
		else if ($erreur == 'pasrempli')
			echo 'Veuillez entrer toutes les informations';
		else if ($erreur == 'mdpcourt')
			echo 'Mot de passe trop court';
			
		echo '</div>';
	}
				
?>