<?php

function verifierAdresseMail($email)
{
    if (preg_match("!^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-zA-Z]{2,4}$!", $email))
        return true;
    return false;
}

function validationPrenom($prenom)
{
    if (strlen($prenom) < 3 || strlen($prenom) > 32)
        return false;
    
    return estMot($prenom);
}

function validationNom($nom)
{
    if (strlen($nom) < 3 || strlen($nom) > 32)
        return false;
    
    return estMot($nom);
}

function validationPassword($password)
{
    if (strlen($password) < 4 || strlen($password) > 8)
        return false;
    
    return true;
}

function joursValide($jour)
{
    if (strlen($jour) < 1 || strlen($jour) > 2)
        return false;
    if (intval($jour) < 1 || intval($jour) > 31)
        return false;
    return true;
}

function moisValide($mois)
{
    if (strlen($mois) != 2)
        return false;
    if (intval($mois) < 1 || intval($mois)  > 12)
        return false;
    return true;
}
function anneeValide($annee)
{
    return strlen($annee) == 4;
}

function heureValide($heure)
{
    if (strlen($heure) < 1 || strlen($heure) > 2)
        return  false;
    
   return estNombre($heure);
}

function lieuValide($lieu)
{
     if (strlen($jour) < 4)
        return false;
     
    return estMot($lieu);
}

function estMot($mot)
{
    return preg_match('/^[a-zA-Z]+$/', $mot);
}

function estNombre($nombre)
{
    return preg_match('/^[0-9]+$/', $nombre);
}
?>
