<?php
session_start();

include 'core.inc.php';
include 'interactionDB.inc.php';

if (!$_SESSION)
{
    header("Location:index.php");
    exit();
}

$id_users = $_SESSION['id'];
$nom_users = $_SESSION['nom'];
$prenom_users = $_SESSION['prenom'];
$email_users = $_SESSION['email'];

head();
insererImage();
userbox();
?>

<script language=javascript>
    function redirige()
    {
        document.location="compte.php";
    } 

</script>

<?php
    if(!isset($_GET['nom']) && ! isset($_GET['prenom']))
    {
        ?>
    <div class="main content">
        <div class="header-main">
            <h1>
                <?php
                echo '<strong>' . $nom_users . ' ' . $prenom_users . '</strong>';
                ?>
            </h1>
            <ul class="profil">
                <li class="texteProfil">
                    C'est vous ! 
                </li>
                <li class="bouton">
                    <input type="button"  value="Editez votre profil !" onclick="redirige()">
                </li>
            </ul>
        </div>
        <hr />
        <div class="presentation">
            <div class="info">
                <?php
                echo "<table> <tbody><tr><td class='caract'> Nom : </td><td> $nom_users </td> </tr> <tr><td class='caract'> Prenom : </td><td> $prenom_users </td></tr><tr><td class='caract'> Email : </td><td> $email_users </td></tr>";

                echo ' </tbody></table></div>';

                $nbContact = nbContact($id_users);
                if (isset($nbContact))
                    echo "<ul class='nbContact'><li class='chiffre'><a href=\"contact.php\">" . $nbContact['i'] . "</a></li>";
                else
                    echo "<ul class='nbContact'><li class='chiffre'><a href=\"contact.php\">0</a></li>";
                echo "<li class='texteInfo'> contacts </li> </ul>";
                ?>
            </div>
            <hr />
            <div class="listeEvenementProfil">
                <?php
                echo "<div class='texteEvenement'><p>Liste de vos évenements</p> </div>";
                $ancienneDate = 0;
                $listeEnvenement = getEvenementUsers($id_users);
                $nbEnvenement = getNombreEvenementUsers($id_users);
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
                ?>
            </div>
        </div>
        

    <?php
    }
    else
    {
        
    }
    footerMobile();
    ?>
