<?php
session_start();

include 'core.inc.php';
include 'interactionDB.inc.php';

if (!$_SESSION)
    redirect("index.php");


head();
insererImage();
userbox();

if (isset($_GET['search']) && !empty($_GET['search']))
    liste_recheche();
else
    redirect("profil.php");

function liste_recheche()
{
    $search = $_GET['search'];
    
    $liste_personne = recherche_db($search);
    
    
    echo '<div class="main content">
                    <div class="header-main">
                        <h1> Voici les personnes pour votre recherche : '. $search . ' </h1>
                    </div>
                    <div class="presentation">
                        <div class="recherche_personne">';
                        
    if (!$liste_personne)
    {
        echo 'Aucune correspondance avec un membre';
    }
    else
    {
        echo'   <table>
                                <thead>
                                    <tr>   
                                        <th> Nom du contact </th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>';
    
        foreach($liste_personne as $key)
        {
            if ($key['id'] == $_SESSION['id'])
                continue;

            $nom = $key['nom'];
            $prenom = $key['prenom'];
            $email = $key['email'];

            echo '<tr>
                        <td><a href="profil.php?nom=' . $nom. '&prenom=' . $prenom . '">' . $nom . ' ' . $prenom . '</a></td>
                        <td>' . $email . '</td>
                     </tr>';

        }

        echo '</tbody>
                </table>';
             
   }
        echo '<div>';
   
}

 footer();
?>
