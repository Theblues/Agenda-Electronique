<?php

include 'interactionDB.inc.php';
include 'core.inc.php';

$id_evenement = $_GET['id_evenement'];

supprimerEvenement($id_evenement);
if (isset($_GET['prenom']) && isset($_GET['nom']))
    redirect("profil.php?nom=" . $_GET['nom'] . "&prenom=" . $_GET['prenom']);

redirect("profil.php");
?>
