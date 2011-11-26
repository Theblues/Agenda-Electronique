<?php

$listeContact = getContact($id_user);

$i = 0;
if (isset($listeContact))
{
    foreach ($listeContact as $attribut => $valeur)
    {
        foreach ($valeur as $att => $val)
        {
            if ($att == 'id')
                $listeContactId[$i] = $val;

            $i++;
        }
    }
}

$listeEnvenementUser = getEvenementUsers($id_user);
$listeEnvenementAll[$id_user] = $listeEnvenementUser;
$nbEnvenement = sizeof($listeEnvenementUser);

$i = $nbEnvenement;
if (isset($listeContactId))
{
    foreach ($listeContactId as $att => $id)
    {
        $listeEnvenementAll[$id] = getEvenementUsers($id);
        $i++;
    }
}
echo '<pre>';
print_r($listeEnvenementAll);
echo '</pre> <br />';


?>


