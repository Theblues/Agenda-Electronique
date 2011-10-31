<?php

session_start();

include 'interactionDB.inc.php';
include 'validation.inc.php';

$id = $_SESSION['id'];
$modifie = false;

if (isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['old_password']) && isset($_POST['new_password']) && isset($_POST['verif_new_password']))
{
    if (!empty($_POST['prenom']))
        $prenom = htmlentities($_POST['prenom']);
    if (!empty($_POST['nom']))
        $nom = htmlentities($_POST['nom']);
    if (!empty($_POST['email']))
        $email = htmlentities($_POST['email']);
    if (!empty($_POST['old_password']) && !empty($_POST['new_password']) && !empty($_POST['verif_new_password']))
    {
        $old_passworl = htmlentities($_POST['old_password']);
        $new_password = htmlentities($_POST['new_password']);
        $verif_new_password = htmlentities($_POST['verif_new_password']);
    }
    
    $valide = false;
    
    if (!isset($nom) && isset($prenom))
        $valide = verificationPersonne($_SESSION['nom'], $prenom);
    else if (isset($nom) && isset($prenom))
        $valide = verificationPersonne($nom, $prenom);
    else if (!isset($prenom))
        $valide = false;

    if ($valide == true && validationPrenom($prenom))
    {
        $modifie = true;
        modifierCompte('prenom', $prenom, $id);
        $_SESSION['prenom'] = $prenom;
    }


    $valide = false;

    if (isset($nom) && !isset($prenom))
        $valide = !verificationPersonne($nom, $_SESSION['prenom']);
    else if (isset($nom) && isset($prenom))
        $valide = !verificationPersonne($nom, $prenom);
    else if (!isset($nom))
        $valide = false;

    if ($valide == true && validationNom($nom))
    {
          $modifie = true;
        modifierCompte('nom', $nom, $id);
        $_SESSION['nom'] = $nom;
    }

    if (isset($email) && verifierAdresseMail($email))
        if (!verificationEmail($email))
        {
              $modifie = true;
            modifierCompte('email', $email, $id);
            $_SESSION['email'] = $email;
        }

    if (isset($old_password) && isset($new_password) && isset($verif_new_password))
        if (verifAncienPassword($id, $old_password))
            if ($new_password == $verif_new_password)
                if (validationPassword($password))
                {
                      $modifie = true;
                    modifierCompte('password', $password, $id);
                }
}

if ($modifie == true)
    header("Location:compte.php?id=modifie");
else
    header("Location:compte.php?id=nomodifie");

?>
