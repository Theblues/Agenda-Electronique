<?php

function head()
{
    echo '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
    echo ' <html><head><title>Agenda</title><link rel="stylesheet" type="text/css" href="css/style.css">';
    echo '</head><body>';
    echo ' <div class="site"> <div class="agenda-header"> <div class="header content">';
}

function insererImage()
{
    $jour = Date('d');
    $mois = Date('m');
    $annee = Date("Y");
    if (isset($_SESSION))
        echo "<a class=\"lien-agenda\" href=\"index.php?id=mois&jours=$jour&mois=$mois&annee=$annee\"><img class=\"a-logo\" src=\"images/agenda_text.gif\"></a>";
    else
        echo '<a class="lien-agenda" href="index.php"><img class="a-logo" src="images/agenda_text.gif"></a>';
}

function userbox()
{
    echo '<div class="userbox">    <div class="name">';
        $prenom = $_SESSION['prenom'];
        echo "<a class=\"name\" href=\"profil.php\">$prenom</a>";
  echo'  </div>
		<ul class="usernav">
			<li> <a href="contact.php"> Contact </a></li>
			<li><a href="ajoutContact.php"> Ajouter contact </a>
			<li><a href="#"> Messagerie </a></li>
			<li><a href="compte.php"> Gestion du compte </a></li>
			<li><a href="deconnexion.php"> Deconnexion </a></li>
        	</ul>
	</div></div>';
        
        recherche();
    echo'</div>';
}

 function recherche()
 {
     echo '<div class="recherche">
                    <form id="recherche" method="get" action="recherche.php">
                        <input type="text" name="search" value="" size="15" value="" placeholder="Rechercher..." />
                    </form>
               </div>';
 }

function footer()
{
    echo ' <div class="agenda-footer1"><div class="footer content"> &copy 2011 Erwan et <span style="text-decoration:line-through;">Ridhoini</span></div></div> </div></body></html>';
}

function footerMobile()
{
    echo ' <div class="agenda-footer2"><div class="footer content"> &copy 2011 Erwan et <span style="text-decoration:line-through;">Ridhoini</span></div></div> </div></body></html>';
}

function redirect($url)
{
    header("Location: $url");
    exit();
}

function div_special($texte)
{
    if ($texte == 'inscription')
    {
         echo '<div class ="special_marche">';
        echo 'Inscription réussi !';
        echo '<a href="index.php"> Connectez-vous ! </a>';
    }
    echo '<div class ="special_erreur">';
    if ($texte == 'pasenvoye')
        echo 'Les informations n\'ont pas été envoyé';
    else if ($texte == 'verif')
        echo 'Les deux mots de passe sont différents';
    else if ($texte == 'pasrempli')
        echo 'Veuillez entrer toutes les informations';
    else if ($texte == 'longmdp')
        echo 'Mot de passe est de mauvaise taille';
    else if ($texte == 'nomfaux')
        echo 'Mauvais Nom';
    else if ($texte == 'prenomfaux')
        echo 'Mauvais Prenom';
    else if ($texte == 'emailfaux')
        echo 'Mauvais Email';
    else if ($texte == 'emaillong')
        echo 'Email trop long';
    else if ($texte == 'emailUsed')
        echo 'Email déjà Utilisé';
    else if ($texte == 'personneUsed')
        echo 'Le nom ou le prenom est déjà utilisé';

    echo '</div>';
}

function div_test($nom, $prenom, $email)
{
     echo '<div class ="special">';
    echo "$nom $prenom $email";
    echo '</div>';
}
?>
