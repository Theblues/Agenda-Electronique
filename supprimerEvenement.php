<?php

include 'interactionDB.inc.php';

$id_evenement = $_GET['id_evenement'];

supprimerEvenement($id_evenement);
header("Location:profil.php");
?>
