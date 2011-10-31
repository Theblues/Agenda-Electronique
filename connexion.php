<?php
session_start();

include 'interactionDB.inc.php';

if (isset($_POST['email']) && isset($_POST['passwd']))
{
    if (!empty($_POST['email']) && !empty($_POST['passwd']))
    {
        $email = htmlentities($_POST['email']);
        $passwd = htmlentities($_POST['passwd']);

        $result = verifCompte($email, $passwd);

        if ($result)
        {
            $resultInfo = infoCompteviaEmail($email);
            
             foreach($resultInfo AS $attribut => $valeur)
                 $_SESSION[$attribut] = $valeur;
            
            $jour = Date('d');
            $mois = Date('m');
            $annee = Date("Y");

            header("Location:index.php?id=mois&jours=$jour&mois=$mois&annee=$annee");
        }
        else
            header("Location:index.php?id=fail");
    }
    else
        header("Location:index.php?id=fail");
}
?>