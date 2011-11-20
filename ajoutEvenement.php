<?php
session_start();

include 'core.inc.php';
include 'interactionDB.inc.php';
include 'validation.inc.php';

if (!$_SESSION)
	redirect("index.php");

$jour = htmlspecialchars($_GET['jour']);
$moisNum = htmlspecialchars($_GET['mois']);
$annee = htmlspecialchars($_GET['annee']);

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
        <form id="ajoutevt" method="post" action="<?php echo "ajoutEvenement.php?action=ajoutEvent&jour=$jour&mois=$moisNum&annee=$annee"; ?>">
            <table>
                <tbody>
                    <tr>
                        <td>
                            Date de l'evenement (JJ/MM/AAAA)
                        </td>
                        <td>
                            <input id="date" type="date" value="<?php echo "$jour/$moisNum/$annee"; ?>"  name="date_event" required/>
                        </td>
                    </tr>
                    <tr>
                        <td> Titre de l'évenement :</td>
                        <td> <input id="TitreEvt" type="text" name="titreEvenement" required></td>
                    </tr>
                    <tr>
                        <td> Définir heures de début/fin : </td>
                        <td><input type="checkbox" name="heure" id="heure" /></td>
                    </tr>
                    <tr id="tr_heure_debut" style="display:none;">
                        <td>Heure Début</td>
                         <td><input type="time" name="heure_debut" id="heure_debut" /></td>
                    </tr>
                     <tr id="tr_heure_fin" style="display:none;">
                        <td>Heure Fin</td>
                         <td><input type="time" name="heure_fin" id="heure_fin" /></td>
                    </tr>
                    <tr>
                        <td>Ajouter un lieu </td>
                        <td><input type="checkbox" name="lieu_checkbox" id="lieu_checkbox" /></td>
                    <tr id="tr_lieu_event" style="display:none;">
                        <td> Le lieu de l'évenement : </td>
                        <td> <input id="lieuEvt" type="text" value="" name="lieuEvenement"></td>
                    </tr>
                    <tr>
                        <td>Ajouter une description </td>
                        <td><input type="checkbox" name="desc_checkbox" id="desc_checkbox" /></td>
                    <tr id="tr_desc_event" style="display:none;">
                        <td> Description de l'évenement : </td>
                        <td> <input id="descriptionEvt" type="text" value="" name="descriptionEvenement"></td>
                    </tr>
                    <tr>
                        <td><input id="AjouterEvt" type="submit" value="Ajouter l'évenement" name="ajouter"></td>
                    </tr>
                </tbody>
            </table>
        </form>
        <script type="text/javascript">          
        $("input[type=checkbox]").click(function (index) {
            if ($('#heure').attr('checked'))
            {
                $('#tr_heure_debut').show("slow");
                $('#tr_heure_fin').show("slow");
                $("#heure_debut").attr({
                    required : true
                });
                $("#heure_fin").attr({
                    required : true
                });
            }
            else
            {
                $('#tr_heure_debut').hide("slow");
                $('#tr_heure_fin').hide("slow");
                $("#heure_debut").attr({
                    required : false
                });
                $("#heure_fin").attr({
                    required : false
                });
            }
            
            // affiche le tr pour le lieu
            if ($('#lieu_checkbox').attr('checked'))
                $('#tr_lieu_event').show('slow');
            else
                $('#tr_lieu_event').hide('slow');
            //afiche le tr pour la description
            if ($('#desc_checkbox').attr('checked'))
                $('#tr_desc_event').show('slow');
            else
                $('#tr_desc_event').hide('slow');
        });

</script>
    </div>
</div>
<?php
$id_users = $_SESSION['id'];

$action = (isset($_GET['action'])) ? $_GET['action'] : '';

if ($action == "ajoutEvent")
{
        $date = htmlspecialchars($_POST["date_event"]);
        $delimiter  = $date[2];
        $date_couper = explode($delimiter, $date);
        $jourF = $date_couper[0];
        $moisF = $date_couper[1];
        $anneeF = $date_couper[3];
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
                        $heure_debut = NULL;
                        $heure_fin = NULL;
                        $lieu = NULL;
                        $description = NULL;
                        if (isset($_POST['heure_debut']) && !empty($_POST['heure_debut']))
                            $heure_debut = $_POST['heure_debut'];
                        if (isset($_POST['heure_fin']) && !empty($_POST['heure_fin']))
                            $heure_fin = $_POST['heure_fin'];
                        if (isset($_POST['lieuEvenement']) && !empty($_POST['lieuEvenement']))
                            $lieu = $_POST['lieuEvenement'];
                        if (isset($_POST['descriptionEvenement']) && !empty($_POST['descriptionEvenement']))
                            $description = $_POST['descriptionEvenement'];


                        
                        if (!dureeValide($heure_debut))
                            $heure_debut = NULL;
                        if (!dureeValide($heure_fin))
                            $heure_fin = NULL;
                        if (!lieuValide($lieu))
                            $lieu = NULL;
                        
                        // pour debugger
                        echo "<br /> <br />";
                        
                        ajouterEvenement($id_users, $date, $titreF, $lieu, $heure_debut, $heure_fin, $description);
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
footer();
?>
