<?php
	include "string.inc.php";
	
	// Fonction pour afficher le calendrier
	function afficherCalendrier($periode) 
	{
		$leCalendrier = "";
		// Tableau des valeurs possibles pour un numéro de jour dans la semaine
		$tableau = Array("0", "1", "2", "3", "4", "5", "6", "0");
		$nb_jour = Date("t", mktime(0, 0, 0, getMonth($periode), 1, getYear($periode)));
		$pas = 0;
		$indexe = 1;
		// Affichage du mois et de l'année
		$leCalendrier .= "\n\t<h2>» " . monthNumToName(getMonth($periode)) . " " . getYear($periode) . "</h2>";
		// Affichage des entêtes
		$leCalendrier .= "
		<table class=\"libelle\">
			<tr>
                            <td>L</td>
                            <td>M</td>
                            <td>M</td>
                            <td>J</td>
                            <td>V</td>
                            <td>S</td>
                            <td>D</td>
                        </tr>";
		// Tant que l'on n'a pas affecté tous les jours du mois traité
		while ($pas < $nb_jour) 
		{
			if ($indexe == 1) 
				$leCalendrier .= "\n\t<tr class=\"ligne\">";
			// Si le jour calendrier == jour de la semaine en cours
			if (Date("w", mktime(0, 0, 0, getMonth($periode), 1 + $pas, getYear($periode))) == $tableau[$indexe]) 
			{
				// Si jour calendrier == aujourd'hui
				$afficheJour = Date("j", mktime(0, 0, 0, getMonth($periode), 1 + $pas, getYear($periode)));
				if (Date("Y-m-d", mktime(0, 0, 0, getMonth($periode), 1 + $pas, getYear($periode))) == Date("Y-m-d")) 
					$class = " class=\"itemCurrentItem\"";
				else
				{
					// 1 est toujours vrai => on affiche un lien à chaque fois
					// A vous de faire les tests nécessaire si vous gérer un agenda par exemple
					if (true)
					{
						$class = " class=\"itemExistingItem\"";
						$afficheJour = "<a href=\"\"?phpMyAdmin=f8aa7401db868c47ec1c5040c0d7b43d>" . Date("j", mktime(0, 0, 0, getMonth($periode), 1 + $pas, getYear($periode))) . "</a>";
					}
					else
						$class = "";
				}
				// Ajout de la case avec la date
				$leCalendrier .= "\n\t\t<td$class>$afficheJour</td>";
				$pas++;
			}
			//
			else
				// Ajout d'une case vide
				$leCalendrier .= "\n\t\t<td> </td>";
				
			if ($indexe == 7 && $pas < $nb_jour) 
                        {
                            $leCalendrier .= "\n\t</tr>"; 
                            $indexe = 1;
                        }
			else 
				$indexe++;
		}
		// Ajustement du tableau
		for ($i = $indexe; $i <= 7; $i++)
			$leCalendrier .= "\n\t\t<td> </td>";

		$leCalendrier .= "\n\t</tr>\n</table>";
                
		// Retour de la chaine contenant le Calendrier
		return $leCalendrier;
	}
	
?>