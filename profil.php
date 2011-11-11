<?php
session_start();

include 'core.inc.php';
include 'interactionDB.inc.php';

if (!$_SESSION)
    redirect("index.php");

$id_user = $_SESSION['id'];
$nom_user = $_SESSION['nom'];
$prenom_user = $_SESSION['prenom'];
$email_user = $_SESSION['email'];
$is_contact = false;
$is_vous = true;

if (isset($_GET['nom']) && isset($_GET['prenom']))
{
    $nom_user = htmlspecialchars($_GET['nom']);
    $prenom_user = htmlspecialchars($_GET['prenom']);
    $info_user = infoCompteviaPersonne($nom_user, $prenom_user);
    
    if ($info_user)
    {
        $id_user = $info_user['id'];
        if ($id_user == $_SESSION['id'])
            redirect("profil.php");

        $email_user = $info_user['email'];
        $is_contact = dejaContact($_SESSION['id'], $id_user);
        $is_vous = false;
    }
    else
        redirect("profil.php?error=personne");
}

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
        <?php 
            if (isset($_GET['error']) && $_GET['error'] == 'personne')
            {
                echo '<h1><strong><font color="red">Cette Personne n\'existe pas</font></strong></h1>';
            }
             else
             {

                echo '<h1><strong>' . $nom_user . ' ' . $prenom_user . '</strong></h1>';

                if ($is_vous == true)
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
                elseif($is_contact == false)
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
                    if ($is_contact == false)
                        echo "<ul class='nbContact'><li class='chiffre'><a href=\"contact.php\">" . $nbContact['i'] . "</a></li>";
                    else
                        echo "<ul class='nbContact'><li class='chiffre'><a href=\"contact.php?nom=$nom_user&prenom=$prenom_user\">" . $nbContact['i'] . "</a></li>";
                }
                else
                {
                    if ($is_contact == false)
                        echo "<ul class='nbContact'><li class='chiffre'><a href=\"contact.php\">0</a></li>";
                    else
                        echo "<ul class='nbContact'><li class='chiffre'><a href=\"contact.php?nom=$nom_user&prenom=$prenom_user\">0</a></li>";
                }
                echo "<li class='texteInfo'> contacts </li> </ul>";

                echo '</div><hr />
                          <div class="listeEvenementProfil">';

                if( $is_contact == true || $is_vous == true)
                {
                    if ($is_vous == true)
                        echo "<div class='texteEvenement'><p>Liste de vos évenements</p> </div>";
                    else 
                        echo "<div class='texteEvenement'><p>Liste des évenements de $nom_user $prenom_user</p> </div>";
                    $ancienneDate = 0;
                    $listeEnvenement = getEvenementUsers($id_user);
                    $nbEnvenement = getNombreEvenementUsers($id_user);
                    if ($nbEnvenement == 0)
                    {
                        if ($is_vous == true)
                        echo 'Vous n\'avez aucun evenement';
                    else 
                        echo "$nom_user $prenom_userecho n'a aucun évenement";
                    }
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
                                if ($att == 'dateevenement')
                                    $date = $val;
                                if ($att == 'lieu')
                                    $lieu = $val;
                                if ($att == 'dureevenement')
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
                            if ($is_vous == true)
                                echo "<span class='croix'><a href='supprimerEvenement.php?id_evenement=$id_evenement'><img class=\"a-logo\" src=\"images/delete.gif\"></a></span>";
                            else
                                echo "<span class='croix'><a href='supprimerEvenement.php?id_evenement=$id_evenement&nom=$nom_user&prenom=$prenom_user'><img class=\"a-logo\" src=\"images/delete.gif\"></a></span>";
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
                else
                    echo "<div class='texteEvenement'><p>Vous devez l'avoir dans vos contacts pour voir ses évenements !</p> </div>";
                
                echo '</div></div>';
             }
        footerMobile();
    ?>
