<?php

include "string.inc.php";

$id_users = $_SESSION['id'];

$jour = $_GET['jours'];
$jour = modif_int($jour);
$moisNum = $_GET['mois'];
$moisNum = modif_int($moisNum);
$moisNom = monthNumToName(intval($moisNum));
$annee = $_GET['annee'];

$periode = $annee . '-' . $moisNum . '-' . $jour;

$nbJours = Date("t", mktime(0, 0, 0, getMonth($periode), 1, getYear($periode)));

// on recupere le mois prochain
$moisProchainNum = intval($moisNum) + 1;
$moisProchainNom = monthNumToName($moisProchainNum);
$anneeduMoisProchain = getAnnee($moisProchainNum, $annee, 'suivant');
if ($moisProchainNum < 10)
    $moisProchainNum = '0' . $moisProchainNum;
else if ($moisProchainNum == 13)
    $moisProchainNum = '01';

// on recupere le mois precedent
$moisPrecedentNum = intval($moisNum) - 1;

$moisPrecedentNom = monthNumToName($moisPrecedentNum);
$anneeduMoisPrecedent = getAnnee($moisPrecedentNum, $annee, 'precedent');

if ($moisPrecedentNum < 10 && $moisPrecedentNum != 0)
    $moisPrecedentNum = '0' . $moisPrecedentNum;
else if ($moisPrecedentNum == 0)
    $moisPrecedentNum = '12';

// le premier jour du mois
$debut = Date("w", mktime(0, 0, 0, getMonth($periode), 1, getYear($periode))) - 1;
if ($debut < 0)
    $debut = 6;

echo "<table class='mois'>
                <tr><td class='mois' onmouseover=\"this.style.background='red'\" onmouseout=\"this.style.background='#2E2D2D'\"onclick='clickCase($jour, $moisPrecedentNum, $anneeduMoisPrecedent)'> << $moisPrecedentNom $anneeduMoisPrecedent</td>
                    <td class='mois'> $moisNom $annee </td>
                    <td class='mois' onmouseover=\"this.style.background='red'\" onmouseout=\"this.style.background='#2E2D2D'\" onclick='clickCase($jour, $moisProchainNum, $anneeduMoisProchain)'> $moisProchainNom $anneeduMoisProchain >></td>
                 </tr>
          </table>
          <table><tr class='jours'><td>Lundi</td><td>Mardi</td><td>Mercredi</td><td>Jeudi</td><td>Vendredi</td><td>Samedi</td><td>Dimanche</td></tr>";

$nbSemaine = ceil(($nbJours + $debut) / 7);

$j = 0;
while ($j < $debut)
{
    echo '<td class="beige_clair"></td>';
    $j++;
}

//remplis le tableau
$k = 1;
for ($i = 1; $i <= $nbJours; $i++)
{
    $modulo = $debut - 1 + $i;
    if ($modulo % 7 == 0)
    {
        echo '</tr><tr>';
        $k++;
    }
    if ($i == $jour)
        echo "<td class='jour_selected' onmouseover=\"this.style.background='red'\" onmouseout=\"this.style.background='#A7C9AE'\" onclick='clickCase($i, $moisNum, $annee)'>$i</td>";
    else if ($i == Date('d') && $moisNum == Date('m') && $annee == Date('Y'))
        echo "<td class='jour_courant' onmouseover=\"this.style.background='red'\" onmouseout=\"this.style.background='#BF5B00'\" onclick='clickCase($i, $moisNum, $annee)'>$i</td>";
    else if ($k % 2 == 1)
        echo "<td class='beige_clair' onmouseover=\"this.style.background='red'\" onmouseout=\"this.style.background='#FFEDB0'\" onclick='clickCase($i, $moisNum, $annee)'>$i</td>";
    else
        echo "<td class='beige_fonce' onmouseover=\"this.style.background='red'\" onmouseout=\"this.style.background='#D6A249'\" onclick='clickCase($i,  $moisNum, $annee)'>$i</td>";
}
// permet de remplir la couleur a la fin du tableau
$i = $nbJours + $debut;
$nbCase = $nbSemaine * 7;
while ($i < $nbCase)
{
    if ($k % 2 == 1)
        echo '<td class="beige_clair"></td>';
    else
        echo '<td class="beige_fonce"></td>';

    $i++;
}

echo '</tr></table>';
?>

<script type="text/javascript">
    // lorsqu'on click sur la case ca modifie la date
    function clickCase(jour, mois, annee)
    {
        if (mois < 10 && mois != 0)
        {
            mois = '0' + mois;
        }
        if (jour < 10 && jour != 0)
        {
            jour = '0' + jour;
        }
        document.location="selection.php?temps=mois&jours=" + jour + "&mois=" + mois + "&annee=" + annee;
    }
</script>

<span class='description'>
    <?php

    echo "<div class='jourSelectionne'> $jour/$moisNum/$annee</div>";
    echo "<div class='ajoutEvenement'> <a href='ajoutEvenement.php?jour=$jour&mois=$moisNum&annee=$annee'>Ajouter un Evénement</a></div>";
    echo "<div class='listeEvenement'><p><u>Vos évenements du jour : </u></p>";
    echo '<ul>';
    $listeEvenement = listeEvenementJour($id_users, $periode);

    if (!$listeEvenement)
        echo '<li>Aucun évenement pour ce jour.</li>';
    else
    {
        foreach ($listeEvenement AS $attribut => $valeur)
        {
            if ($valeur == 0)
                echo '<li>Aucun évenement pour ce jour.</li>';
            echo '<li>' . $valeur['titre'];

            if (isset($valeur['heure_debut']))
                echo " (" . $valeur['heure_debut'] . "h-" . $valeur['heure_fin'] . ")";
            echo '</li>';
            if (isset($valeur['description']) || isset($valeur['lieu']))
            {
                echo "<ul>";
                if (isset($valeur['description']) && !isset($valeur['lieu']))
                    echo '<li>description : ' . $valeur['description'] . '</li>';
                else if (!isset($valeur['description']) && isset($valeur['lieu']))
                    echo '<li>lieu : ' . $valeur['lieu'] . '</li>';
                echo '</ul>';
            }
        }
    }
    echo "</ul></div></span>";
    ?>
