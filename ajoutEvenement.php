<?php
session_start();

include 'core.inc.php';
include 'interactionDB.inc.php';
include 'validation.inc.php';

if (!$_SESSION)
	redirect("index.php");

$jour = $_GET['jour'];
$moisNum = $_GET['mois'];
$annee = $_GET['annee'];

head();
insererImage();
userbox();
?>

<div class="ajouteEvt content">
    <div class="production-info agenda">
        <h3> <b>Ajouter un évenement </b></h3>
        <!--<p> Ceci permet de modifer vos informations personnelles. Pour revenir à votre profil c'est <a href="profil.php"> ici </a> </p>-->
    </div>
    <div class="formulaire">
        <form id="ajoutevt" method="post" action="<?php echo "ajoutEvenement.php?jour=$jour&mois=$moisNum&annee=$annee"; ?>">
            <table>
                <tbody>
                    <tr>
                        <td> Jour de l'évenement :</td> 
                        <td><input id="JourEvt" type="text" value="<?php echo $jour; ?>" name="jourEvenement"></td>
                    </tr>
                    <tr>
                        <td> Mois de l'évenement :</td>
                        <td><input id="MoisEvt" type="text" value="<?php echo $moisNum; ?>" name="moisEvenement"></td>
                    </tr>
                    <tr>
                        <td> Année de l'évenement : </td>
                        <td><input id="AnneeEvt" type="text" value="<?php echo $annee; ?>" name="anneeEvenement"></td>
                    </tr>
                    <tr>
                        <td> Titre de l'évenement :</td>
                        <td> <input id="TitreEvt" type="text" value="Sans titre" name="titreEvenement"></td>
                    </tr>
                    <tr>
                        <td> La durée de l'évenement : </td>
                        <td> <input id="dureeEvt" type="text" value="" name="dureeEvenement"></td>
                    </tr>
                    <tr>
                        <td> Le lieu de l'évenement : </td>
                        <td> <input id="lieuEvt" type="text" value="" name="lieuEvenement"></td>
                    </tr>
                    <tr>
                        <td> Description de l'évenement : </td>
                        <td> <input id="descriptionEvt" type="text" value="" name="descriptionEvenement"></td>
                    </tr>
                    <tr>
                        <td><input id="AjouterEvt" type="submit" value="Ajouter l'évenement" name="ajouter"></td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>
<?php
$id_users = $_SESSION['id'];
if (isset($_POST['jourEvenement']) && isset($_POST['moisEvenement']) && isset($_POST['anneeEvenement']) && isset($_POST['titreEvenement']))
{
    if (!empty($_POST["jourEvenement"]) && !empty($_POST["moisEvenement"]) && !empty($_POST["anneeEvenement"]) && !empty($_POST["titreEvenement"]))
    {
        $jourF = $_POST["jourEvenement"];
        $moisF = $_POST["moisEvenement"];
        $anneeF = $_POST["anneeEvenement"];
        $titreF = $_POST["titreEvenement"];
        $date = $anneeF . '-' . $moisF . '-' . $jourF;

        if (joursValide($jourF))
        {
            if (moisValide($moisF))
            {
                if (anneeValide($anneeF))
                {
                    if (evenementValide($id_users, $date, $titreF))
                    {
                        $duree = NULL;
                        $lieu = NULL;
                        $description = NULL;
                        if (isset($_POST['dureeEvenement']) && !empty($_POST['dureeEvenement']))
                            $duree = $_POST['dureeEvenement'];
                        if (isset($_POST['lieuEvenement']) && !empty($_POST['lieuEvenement']))
                            $lieu = $_POST['lieuEvenement'];
                        if (isset($_POST['descriptionEvenement']) && !empty($_POST['descriptionEvenement']))
                            $description = $_POST['descriptionEvenement'];

                        echo $lieu . ' ' . $_POST['lieuEvenement'] . '<br />';
                        echo $duree . ' ' . $_POST['dureeEvenement']  . '<br />';
                        echo $description . ' ' . $_POST['descriptionEvenement']  . '<br />';
                        
                      /*  if (!dureeValide($duree))
                            $duree = NULL;
                        if (!lieuValide($lieu))
                            $lieu = NULL;*/
                        
                        // pour debugger
                        echo "<br /> <br />";
                        echo $lieu . ' ' . $_POST['lieuEvenement'] . '<br />';
                        echo $duree . ' ' . $_POST['dureeEvenement']  . '<br />';
                        echo $description . ' ' . $_POST['descriptionEvenement']  . '<br />';
                        
                        ajouterEvenement($id_users, $date, $titreF, $lieu, $duree, $description);
                        echo "<div class='special_marche'> Evénement ajouté </div>";
                    }
                    else
                        echo "<div class='special_erreur'> Evénement déjà présent</div>";
                }
                else
                    echo "<div class='special_erreur'> L'année est mauvaise </div>";
            }
            else
                echo "<div class='special_erreur'> Le mois est mauvais </div>";
        }
        else
            echo "<div class='special_erreur'> Le jour est mauvais </div>";
    }
    else
        echo "<div class='special_erreur'> Veuillez entrez le jour, le mois, l'année et le titre de l'évenement </div>";
}
footer();
?>
