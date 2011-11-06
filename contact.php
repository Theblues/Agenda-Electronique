<?php
session_start();

include 'core.inc.php';
include 'interactionDB.inc.php';

if (!$_SESSION)
{
    header("Location:index.php");
    exit();
}

$id_users = $_SESSION['id'];
$nom_users = $_SESSION['nom'];
$prenom_users = $_SESSION['prenom'];
$email_users = $_SESSION['email'];

head();
insererImage();
userbox();
?>

<div class='main content'>
    <div class="header-main">
        <h1> Voici vos contact </h1>
    </div>
    <div class="presentation">
        <div class="listeContact">
            <table>
                <tbody>           
                    <tr>
                        <td class='caract'> Nom du contact </td>
                        <td class='caract'> Email du contact </td>
                    </tr>
                    <?php
                    $listeContact = getContact($id_users);
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
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
footer();
?>
