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
            <p> En ajoutant un contact, vous pouvez voir tous les évenements de celui-ci</p>
        </div>
        <div class="formulaire">
            <form id="ajout-contact" method="post" action="ajoutContact.php?action=verif">
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
    </div>';
}

function verif()
{
    $id_user = $_SESSION['id'];
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
                    $id_userContact = $info['id'];
                    if (!dejaContact($id_user, $id_userContact))
                    {
                        ajouterContact($id_user, $id_userContact);
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
                if (!dejaContact($id_user, $idContact))
                {
                        ajouterContact($id_user, $idContact);
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
}

$action = $_GET['action'];

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
