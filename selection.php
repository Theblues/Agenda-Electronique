<?php

$temps = $_GET['temps'];
$jour = $_GET['jours'];
$moisNum = $_GET['mois'];
$annee = $_GET['annee'];

header("Location:index.php?id=$temps&jours=$jour&mois=$moisNum&annee=$annee");
?>
