<?php
session_start();

include 'interactionDB.inc.php';

$id_users = $_SESSION['id'];

$date = $_GET['dateEvenement'];
$titre = $_GET['titreEvenement'];

supprimerEvenement($id_users, $date, $titre);
header("Location:profil.php");
?>
