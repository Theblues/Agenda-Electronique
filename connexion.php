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

    redirect("index.php?id=planning");
}
else
    redirect("index.php?id=fail");
redirect("index.php");
?>
