<?php
session_start();

include 'core.inc.php';

if (!$_SESSION)
{
    header("Location:index.php");
    exit();
}

head();
insererImage();
userbox();
?>
</script>

<div class="profiltab content">
    <div class="production-info agenda">
        <h3> <b>Gestion du compte </b></h3>
        <p> Ceci permet de modifer vos informations personnelles. Pour revenir à votre profil c'est <a href="profil.php"> ici </a> </p>
    </div>
    <div class="formulaire">
        <form id="modif_profil" method="post" action="account.php">
            <table>
                <tbody>
                    <tr>
                        <td> Prénom :</td> 
                        <td> <input id="Prenom" type="text" value="" name="prenom"></td>
                    </tr>
                    <tr>
                <td> Nom :</td>
                <td> <input id="Nom" type="text" value="" name="nom"></td>
                    </tr>
                <tr>
                    <td> Email:</td>
                    <td> <input id="Email" type="text" value="" name="email"></td>
                </tr>
                <tr>
                    <td> Entrer votre ancien mot de passe : </td>
                    <td> <input id="Password" type = "password" name="old_password"> </td>
                </tr>
                <tr>
                    <td> Choisissez un nouveau mot de passe : </td>
                    <td> <input id="Password" type = "password" name="new_password"> </td>
                </tr>
                <tr>
                    <td> Confirmez le mot de passe : </td>
                    <td> <input id="VerifPassword" type="password" name="verif_new_password"> </td>
                </tr>
                <tr>
                    <td> <input id="CreerCompte" type="submit" value="Modifier les informations" name="modifier"></td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>

<?php
if (isset($_GET['id']))
    if ($_GET['id'] == 'modifie')
        echo "<div class='special_marche'> Votre compte a été modifié </div>";
    else if ($_GET['id'] == 'nomodifie')
        echo "<div class='special_erreur'> Votre compte n'a pas pu être modifié !</div>";

footer();
?>
