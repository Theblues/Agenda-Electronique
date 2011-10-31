<?php

// fonctions utiles, $valeur reprÃ©sente une date au format AAAA-MM-JJ
function getSecond($valeur)
{
    return substr($valeur, 17, 2);
}

function getMinute($valeur)
{
    return substr($valeur, 14, 2);
}

function getHour($valeur)
{
    return substr($valeur, 11, 2);
}

function getDay($valeur)
{
    return substr($valeur, 8, 2);
}

function getMonth($valeur)
{
    return substr($valeur, 5, 2);
}

function getYear($valeur)
{
    return substr($valeur, 0, 4);
}

function monthNumToName($mois)
{
    $tableau = Array("", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
    if (intval($mois) > 0 && intval($mois) < 13)
        return $tableau[intval($mois)];
    else if (intval($mois) <= 0)
        return "Décembre";
    else if (intval($mois) >= 13)
        return "Janvier";
}

function getAnnee($mois, $annee, $style)
{
    if (intval($mois) >= 1 && intval($mois) <= 12)
        return $annee;
    else
    {
        if ($style == 'precedent')
            return (--$annee);
        else if ($style == 'suivant')
            return (++$annee);

        if ($style == 'precedent')
            return (--$annee);
        else if ($style == 'suivant')
            return (++$annee);
    }
}
?>


