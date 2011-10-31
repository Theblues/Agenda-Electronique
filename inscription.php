<?php
session_start();

include 'interactionDB.inc.php';
include 'validation.inc.php';
include 'core.inc.php';

head();
insererImage();
?>
</div></div>
<div class="inscription-main content">
    <div class="production-info agenda">
        <h3> <strong>Créer un compte </strong></h3>
        <p> Votre compte donne au servive Agenda. Si vous disposez déjà d'un compte, vous pouvez <a href="index.php"> vous connecter ici.</a></p>
    </div>
    <div class="formulaire">
        <h2> Premier pas avec Agenda </h2>
        <form id="inscription" method="post" action="inscription.php">
            <table>
                <tbody>
                    <tr>
                        <td> Prénom :</td> 
                        <td> <input id="Prenom" type="text" value="" name="prenom">
                    </tr>
                <td> Nom :</td>
                <td> <input id="Nom" type="text" value="" name="nom">
                    </tr>
                <tr>
                    <td> Email:</td>
                    <td> <input id="Email" type="text" value="" name="email"></td>
                </tr>
                <tr>
                    <td> Choisissez un mot de passe : </td>
                    <td> <input id="Password" type = "password" name="password"> </td>
                </tr>
                <tr>
                    <td> Confirmez le mot de passe : </td>
                    <td> <input id="VerifPassword" type="password" name="verifpassword"> </td>
                </tr>
                <tr>
                    <td> <input id="CreerCompte" type="submit" value="Créer un compte" name="ok"></td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>

<?php
if (isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['verifpassword']))
{
    if (empty($_POST['prenom']) || empty($_POST['nom']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['verifpassword']))
        div_special('pasrempli');
    else
    {
        $prenom = htmlentities($_POST['prenom']);
        $nom = htmlentities($_POST['nom']);
        $email = htmlentities($_POST['email']);
        $password = htmlentities($_POST['password']);
        $verifpassword = htmlentities($_POST['verifpassword']);


        if ($password != $verifpassword)
            div_special('verif');
        else if (!validationNom($nom))
            div_special('nomfaux');
        else if (!validationPrenom($prenom))
            div_special('prenomfaux');
        else if (!validationPassword($password))
            div_special('longmdp');
        else if (!verifierAdresseMail($email))
            div_special('emailfaux');
        else if (strlen($email) > 32)
            div_special('emaillong');
        else if (verificationPersonne($nom, $prenom))
            div_special('personneUsed');
        else if (verificationEmail($email))
            div_special('emailUsed');
        else
        {
            inscription($nom, $prenom, $email, $password);
            div_special('inscription');
        }
    }
}
footer();
?>