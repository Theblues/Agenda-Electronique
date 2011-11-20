<?php

session_start();

include 'core.inc.php';
include 'interactionDB.inc.php';

if (!$_SESSION)
redirect("index.php");


head();
insererImage();
userbox();

function form()
{
echo '<div class="ajoutContact content">
        <div class="production-info agenda">
            <h3> <b>Ajouter un contact </b></h3>
            <p> En ajoutant un contact, vous pouvez voir tous les évenements de celui-ci.<br />
            Pour ajouter une personne, vous devez entrer soit son nom et prénom, soit son email.</p>
        </div>
        <div class="formulaire">
        <script type="text/javascript">
            function ajoutviaNomPrenom()
            {
                $("#email").hide();
                $("#nomPrenom").show();
                 $("#Prenom").attr({
                    required : true
                });
                $("#Nom").attr({
                    required : true
                });
                $("#Email").attr({
                    required : false
                });
            }
            function ajoutviaEmail()
            {
                $("#nomPrenom").hide();
                $("#email").show();
                 $("#Prenom").attr({
                    required : false
                });
                $("#Nom").attr({
                    required : false
                });
                $("#Email").attr({
                    required : true
                });
            }
        </script>
            
                     <span style="font-size:18px;">Choisissez l\'une des options ! </span><br /><br />
                    <p>
                    <input type="button"  id="lienNomPrenom" value="Nom et Prenom de la personne" onclick="ajoutviaNomPrenom()" />
                    <span style="font-size:16px;">ou</span>
                    <input type="button"  id="lienEmail" value="Email de la personne" onclick="ajoutviaEmail()" />  
              </p>
            <form id="ajout-contact" method="post" action="ajoutContact.php?action=verif">
                <table id="nomPrenom" style="display:none; margin: 10px 110px auto;">
                    <tbody>
                        <tr>
                            <td> Prénom du contact :</td> 
                            <td> <input id="Prenom" type="text" value="" name="prenomContact" /></td>
                        </tr>
                        <tr>
                            <td> Nom du contact :</td>
                            <td> <input id="Nom" type="text" value="" name="nomContact" /></td>
                        </tr>
                        <tr>
                            <td colspan="2"> <input id="AjouterContact" type="submit" value="Ajouter le contact" name="ajouter" /></td>
                        </tr>
                    </tbody>
                 </table>
                 <table id="email" style="display:none; margin: 10px 110px auto;">
                    <tbody>
                        <tr>
                            <td> Email du contact:</td>
                            <td> <input id="Email" type="email" value="" name="emailContact"></td />
                        </tr>
                        <tr>
                            <td colspan="2"> <input id="AjouterContact" type="submit" value="Ajouter le contact" name="ajouter" /></td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>';
}

function verif()
{
    $id_user = $_SESSION['id'];

    $prenom = htmlentities($_POST['prenomContact']);
    $nom = htmlentities($_POST['nomContact']);

    $email = htmlentities($_POST['emailContact']);

    if (!empty ($prenom) && !empty($nom))
    {
        if (verificationPersonne($nom, $prenom))
        {
            $info = infoCompteviaPersonne($nom, $prenom);
            $idContact = $info['id'];
            if (!dejaContact($id_user, $idContact))
            {
                ajouterContact($id_user, $idContact);
                echo '<div class="special_marche"> Contact ajouté </div>';
            }
            else
                echo '<div class="special_erreur"> Contact déjà entré </div>';
        }
        else
            echo "<div class='special_erreur'> $nom $prenom n'existe pas </div>";
    }
    else if (!empty($email))
    {
        if (verificationEmail($email))
        {
            $info = infoCompteviaEmail($email);
            $idContact = $info['id'];
            if (!dejaContact($id_user, $idContact))
            {
                ajouterContact($id_user, $idContact);
                echo '<div class="special_marche"> Contact ajouté </div>';
            }
            else
                echo '<div class="special_erreur"> Contact déjà entré </div>';
        }
        else
            echo '<div class="special_erreur"> Mauvais Email </div>';
    }
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == 'verif')
{
    form();
    verif();
}
elseif (isset($_GET['nom']) && isset($_GET['prenom']))
{
    $prenom_contact = $_GET['prenom'];
    $nom_contact = $_GET['nom'];

    $info_personne = infoCompteviaPersonne($nom_contact, $prenom_contact);
    $id_contact = $info_personne['id'];

    ajouterContact($_SESSION['id'], $id_contact);
    redirect("profil.php?nom=$nom_contact&prenom=$prenom_contact");
}
else
form();

footer();
?>
