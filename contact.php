<?php
session_start();

include 'core.inc.php';

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



footer();

?>
