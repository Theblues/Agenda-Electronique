<?php
session_start();

include 'core.inc.php';
include 'interactionDB.inc.php';

if (!$_SESSION)
    redirect("index.php");

$id_user = $_SESSION['id'];
$nom_user = $_SESSION['nom'];
$prenom_user = $_SESSION['prenom'];
$email_user = $_SESSION['email'];
$is_contact = false;

if (isset($_GET['nom']) && isset($_GET['prenom']))
{
    $info_user = infoCompteviaPersonne($_GET['nom'], $_GET['prenom']);
    if (!$info_user)
        redirect("contact.php");
    $id_user = $info_user['id'];
    $nom_user = htmlspecialchars($_GET['nom']);
    $prenom_user = htmlspecialchars($_GET['prenom']);
    $email_user = $info_user['email'];
    $is_contact = true;
}

head();
insererImage();
userbox();


echo '
<div class=\'main content\'>
    <div class="header-main">';
 if (!$is_contact)
        echo '<h1> Voici vos contact </h1>';
 else
        echo '<h1> Voci les contacts de ' . $prenom_user . ' ' . $nom_user . '</h1>';

echo'    </div>
    <div class="presentation">
        <div class="listeContact">';
            $listeContact = getContact($id_user);
            if (sizeof($listeContact) == 0)
                echo "$prenom_user $nom_user n'a aucun contact.";
            else
            {
                echo '
            <table>
                <thead>
                    <tr>
                        <th> Nom du contact </th>
                        <th> Email du contact</th>
                    </tr>
                </thead>
                <tbody>';
                    foreach ($listeContact as $attribut => $valeur)
                    {
                        foreach ($valeur as $att => $val)
                        {
                            if ($att == 'nom')
                                $nom_contact = $val;
                            if ($att == 'prenom')
                                $prenom_contact = $val;
                            if ($att == 'email')
                                $email_contact = $val;
                        }
                        echo "
                               <tr>
                                        <td> <a href='profil.php?nom=$nom_contact&prenom=$prenom_contact'>$nom_contact $prenom_contact </a></td>   
                                        <td> $email_contact </td>
                                 </tr>";
                    }
                    echo '
                            </tbody>
                        </table>';

            }
       echo '
       </div>
    </div>
</div>';

footer();
?>
