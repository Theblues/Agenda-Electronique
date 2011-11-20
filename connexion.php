<?php

session_start();

include 'interactionDB.inc.php';
include 'core.inc.php';

$email = htmlentities($_POST['email']);
$passwd = htmlentities($_POST['passwd']);


$result = verifCompte($email, $passwd);

if ($result)
{
    $resultInfo = infoCompteviaEmail($email);

    foreach ($resultInfo AS $attribut => $valeur)
        $_SESSION[$attribut] = $valeur;

    $jour = Date('d');
    $mois = Date('m');
    $annee = Date("Y");

    redirect("index.php?id=mois&jours=$jour&mois=$mois&annee=$annee");
}
else
    redirect("index.php?id=fail");
redirect("index.php");
?>
