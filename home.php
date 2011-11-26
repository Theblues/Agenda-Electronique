<?php
userbox();

$id_user = $_SESSION['id'];
$jour = Date('d');
$mois = Date('m');
$annee = Date("Y");
?>
<div class="main content">
    <div class="pagehead">
        <ul class="tableau">
             <li>
                <?php
                echo "<a href='index.php?id=planning'> Votre Planning </a>";
                ?>
            </li>
            <li>
                <?php
                echo "<a href=\"index.php?id=jour&jours=$jour&mois=$mois&annee=$annee\"> Jour </a>";
                ?>
            </li>
            <li>
                <?php
                echo "<a href=\"index.php?id=semaine&jours=$jour&mois=$mois&annee=$annee\"> Semaine </a>";
                ?>
            </li>
            <li>
                <?php
                echo "<a href=\"index.php?id=mois&jours=$jour&mois=$mois&annee=$annee\"> Mois </a>";
                ?>
            </li>
        </ul>
    </div>
    <div class='calendrier'>
        <?php
        if (isset($_GET['id']))
        {
            if ($_GET['id'] == 'planning')
                include ('calendrier/planning.php');
            else if ($_GET['id'] == 'jour')
                include ("calendrier/jour.php");
            else if ($_GET['id'] == 'semaine')
                include ('calendrier/semaine.php');
            else if ($_GET['id'] == 'mois')
                include ('calendrier/mois.php');
        }
        else
            echo '<div class ="special_erreur"> Mauvaise attribution dans l\'URL<div>'
            ?>
    </div>
</div>
