<?php
session_start();

include 'core.inc.php';
include "interactionDB.inc.php";

head();

insererImage();

if (isset($_SESSION['id']))
    include("home.php");
else
    include("accueil.php");

footer();

?>