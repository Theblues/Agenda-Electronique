<?php
session_start();

include 'core.inc.php';
include 'interactionDB.inc.php';

if (!$_SESSION)
{
    header("Location:index.php");
    exit();
}

$id_user = $_SESSION['id'];
$nom_user = $_SESSION['nom'];
$prenom_user = $_SESSION['prenom'];
$email_user = $_SESSION['email'];
$is_contact = false;
$is_vous = true;

if (isset($_GET['nom']) && isset($_GET['prenom']))
{
    $info_user = infoCompteviaPersonne($_GET['nom'], $_GET['prenom']);
    $id_user = $info_user['id'];
    $nom_user = $_GET['nom'];
    $prenom_user = $_GET['prenom'];
    $email_user = $info_user['email'];
    $is_contact = !dejaContact($_SESSION['id'], $id_user);
    $is_vous = false;
}

echo $is_contact;

head();
insererImage();
userbox();
?>

<script language=javascript>
    function redirige(personne, nom, prenom)
    {
        if (personne == 'user')
            document.location = "compte.php";
        else if (personne == 'non_contact')
            document.location = "ajoutContact.php?nom=" + nom + "&prenom=" + prenom;
    } 

</script>

<div class="main content">
    <div class="header-main">
        <h1>
            <?php
            echo '<strong>' . $nom_user . ' ' . $prenom_user . '</strong>';
            ?>
        </h1>
        <?php
            if ($is_vous)
            {
                echo '<ul class="profil">
                            <li class="texteProfil">
                                C\'est vous ! 
                            </li>
                            <li class="bouton">
                                <input type="button"  value="Editez votre profil !" onclick="redirige(\'user\')">
                            </li>
                        </ul>
                    </div>';
            }
            elseif($is_contact == 'false')
            {
                echo '<ul class="profil">
                            <li class="texteProfil">
                                Ajouter en contact
                            </li>
                            <li class="bouton">
                                <input type="button"  value="Ajoutez le en contact" onclick="redirige(\'non_contact\', \'' . $nom_user .'\',\'' . $prenom_user . '\')">
                            </li>
                        </ul>
                    </div>';
                    
            }
            else
                echo '<br />';
            echo '<hr />
                    <div class="presentation">
                        <div class="info">';
            echo "<table> <tbody><tr><td class='caract'> Nom : </td><td> $nom_user </td> </tr> <tr><td class='caract'> Prenom : </td><td> $prenom_user </td></tr><tr><td class='caract'> Email : </td><td> $email_user </td></tr>";

            echo ' </tbody></table></div>';

            $nbContact = nbContact($id_user);
            if (isset($nbContact))
            {
                if ($is_contact == 'false')
                    echo "<ul class='nbContact'><li class='chiffre'><a href=\"contact.php\">" . $nbContact['i'] . "</a></li>";
                else
                    echo "<ul class='nbContact'><li class='chiffre'><a href=\"contact.php?nom=$nom_user&prenom=$prenom_user\">" . $nbContact['i'] . "</a></li>";
            }
            else
            {
                if ($is_contact == 'false')
                    echo "<ul class='nbContact'><li class='chiffre'><a href=\"contact.php\">0</a></li>";
                else
                    echo "<ul class='nbContact'><li class='chiffre'><a href=\"contact.php?nom=$nom_user&prenom=$prenom_user\">0</a></li>";
            }
            echo "<li class='texteInfo'> contacts </li> </ul>";
            ?>
        </div>
        <hr />
        <div class="listeEvenementProfil">
            <?php
            if( $is_contact == 'true')
            {
                echo "<div class='texteEvenement'><p>Liste de vos évenements</p> </div>";
                $ancienneDate = 0;
                $listeEnvenement = getEvenementUsers($id_user);
                $nbEnvenement = getNombreEvenementUsers($id_user);
                if ($nbEnvenement == 0)
                    echo 'Vous avez aucun evenement';
                else
                {
                    echo "<span class='partie1'><ul>";
                    $iSpan = intval($nbEnvenement / 2);
                    $span = false;
                    $i = 0;

                    foreach ($listeEnvenement as $attribut => $valeur)
                    {
                        foreach ($valeur as $att => $val)
                        {
                            if ($att == 'id_evenement')
                                $id_evenement = $val;
                            if ($att == 'titre')
                                $titre = $val;
                            if ($att == 'dateEvenement')
                                $date = $val;
                            if ($att == 'lieu')
                                $lieu = $val;
                            if ($att == 'dureeEvenement')
                                $dureeEvenement = $val;
                            if ($att == 'description')
                                $description = $val;
                        }

                        if ($ancienneDate == $date && $attribut == $iSpan)
                            $iSpan++;

                        if ($attribut == $iSpan && $i != 0)
                        {
                            $span = true;
                            echo "</ul></ul></span><span class='partie2'>";
                            echo "<ul><li class='dateEvenement'>Evenement de $date</li><ul>";
                        }
                        else if ($ancienneDate != $date && $attribut != 0)
                            echo "</ul><li class='dateEvenement'>Evenement de $date</li><ul>";
                        else if ($ancienneDate != $date)
                            echo "<li class='dateEvenement'>Evenement de $date</li><ul>";

                        echo "<li class='titreEvenement'><span style='color:red;'>Titre</span> : $titre";
                        if (isset($dureeEvenement))
                            echo "($dureeEvenement min)";
                        echo "<span class='croix'><a href='supprimerEvenement.php?id_evenement=$id_evenement'><img class=\"a-logo\" src=\"images/delete.gif\"></a></span>";
                        echo "</li>";
                        if (isset($lieu))
                            echo "<li class='attributEvenement'><span style='color:#FFAB48;'>Lieu</span> : $lieu</li>";
                        if (isset($description))
                            echo "<li class='attributEvenement'><span style='color:#FFAB48;'>Description</span> : $description</li>";

                        $ancienneDate = $date;
                        $i++;
                    }
                    echo '</ul></span>';
                }
            }
            ?>
        </div>
    </div>


    <?php
    footerMobile();
    ?>
