<?php
session_start();

include 'core.inc.php';
include 'interactionDB.inc.php';

if (!$_SESSION)
{
    header("Location:index.php");
    exit();
}

head();
insererImage();
userbox();
?>

<div class="ajoutContact content">
    <div class="production-info agenda">
        <h3> <b>Ajouter un contact </b></h3>
        <!--<p> Ceci permet de modifer vos informations personnelles. Pour revenir à votre profil c'est <a href="profil.php"> ici </a> </p>-->
    </div>
    <div class="formulaire">
        <form id="ajout-contact" method="post" action="ajoutContact.php">
            <table>
                <tbody>
                    <tr>
                        <td> Prénom du contact :</td> 
                        <td> <input id="Prenom" type="text" value="" name="prenomContact"></td>
                    </tr>
                    <tr>
                        <td> Nom du contact :</td>
                        <td> <input id="Nom" type="text" value="" name="nomContact"></td>
                    </tr>
                    <tr class="texte">
                        <td> Ou bien</td>
                    </tr>
                    <tr>
                        <td> Email du contact:</td>
                        <td> <input id="Email" type="text" value="" name="emailContact"></td>
                    </tr>
                    <tr>
                    <td> <input id="AjouterContact" type="submit" value="Ajouter le contact" name="ajouter"></td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>

<?php
$id_users = $_SESSION['id'];
if (isset($_POST['prenomContact']) ||  isset($_POST['nomContact']) || isset($_POST['emailContact']))
{
    if (!empty($_POST['prenomContact']) &&   !empty($_POST['nomContact']))
    {
        $prenom = htmlentities($_POST['prenomContact']);
        $nom = htmlentities($_POST['nomContact']);
    }
    if (!empty($_POST['emailContact']))
        $email = htmlentities($_POST['emailContact']);
    
    if (!isset($prenom) && !isset($nom) && !isset($email))
        echo '<div class="special_erreur"> Entrée le prenom ET le nom  ou le email du contact </div>';
    if (isset($prenom) && isset($nom) && isset ($email))
    {
        if (verificationEmail($email))
        {
            $info = infoCompte($email);
            if ($info['prenom'] == $prenom && $info['nom'] == $nom)
            {
                $id_usersContact = $info['id'];
                if (!dejaContact($id_users, $id_usersContact))
                {
                    ajouterContact($id_users, $id_usersContact);
                    echo '<div class="special_marche"> Contact ajouté </div>';
                }
               else
                   echo '<div class="special_erreur"> Contact déjà entré </div>';
            }
            echo '<div class="special_erreur">L\'Email ne va pas avec cette perssone </div>';
        }
       else
            echo '<div class="special_erreur"> Mauvais Email </div>';
    }
    else if (isset ($prenom) && isset($nom))
    {
        if (verificationPersonne($nom, $prenom))
        {
            $info = infoCompteviaPersonne($nom, $prenom);
            $idContact = $info['id'];
            if (!dejaContact($id_users, $idContact))
            {
                    ajouterContact($id_users, $idContact);
                    echo '<div class="special_marche"> Contact ajouté </div>';
            }
            else
                 echo '<div class="special_erreur"> Contact déjà entré </div>';
        }
        else
            echo '<div class="special_erreur"> Cette personne n\'exixte pas </div>';
    }
    else if (isset($email))
    {
        if (verificationEmail($email))
        {
            $info = infoCompteviaEmail($email);
            $idContact = $info['id'];
            if (!dejaContact($id_users, $idContact))
            {
                    ajouterContact($id_users, $idContact);
                    echo '<div class="special_marche"> Contact ajouté </div>';
            }
            else
                echo '<div class="special_erreur"> Contact déjà entré </div>';
        }
        else
            echo '<div class="special_erreur"> Mauvais Email </div>';
    }
    
}
footer();
?>
