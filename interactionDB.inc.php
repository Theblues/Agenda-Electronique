<?php

/**
 * se connecte a la DB
 * @return PDO 
 */
function connectionDB()
{
    try
    {
        $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        $db = new PDO('mysql:host=localhost;dbname=CPL', 'root', '', $pdo_options);
        //$db = new PDO('pgsql:host=woody;dbname=le100700', 'le100700', 'CPL', $pdo_options);
    }
    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }

    return $db;
}

/**
 *return les informations sur le compte grace a un email
 * @param type $email
 * @return type 
 */
function infoCompteviaEmail($email)
{
    $db = connectionDB();
    $request = $db->prepare('SELECT id, nom, prenom, email FROM accounts WHERE email = :email');
    $request->execute(array(':email' => $email));
    $result = $request->fetch(PDO::FETCH_ASSOC);
    return $result;
}

/**
 * return les informations sur le compte grace a une personne
 * @param type $nom
 * @param type $prenom
 * @return type 
 */
function infoCompteviaPersonne($nom, $prenom)
{
    $db = connectionDB();
    $request = $db->prepare('SELECT id, nom, prenom, email FROM accounts WHERE nom = :nom AND prenom = :prenom');
    $request->execute(array(':nom' => $nom, 'prenom' => $prenom));
    $result = $request->fetch(PDO::FETCH_ASSOC);
    return $result;
}

/**
 * verifie
 * @param type $email
 * @param type $passwd
 * @return type 
 */
function verifCompte($email, $passwd)
{
    $db = connectionDB();
    $request = $db->prepare('SELECT * FROM accounts WHERE email = :email AND password = :passwd');
    $request->execute(array(':email' => $email, ':passwd' => $passwd));
    $result = $request->fetch(PDO::FETCH_ASSOC);

    return $result;
}

/**
 * Verifie si l'email n'est pas deja utilis�
 * @param type $email
 * @return type 
 */
function verificationEmail($email)
{
    $db = connectionDB();
    
    $requestEmail = $db->prepare('SELECT * FROM accounts WHERE email = :email');
    $requestEmail->execute(array(':email' => $email));
    $personne_cherche = $requestEmail->fetch(PDO::FETCH_ASSOC);

    if ($personne_cherche)
        return true;

    return false;
}

function verificationPersonne($nom, $prenom)
{
    $db = connectionDB();
    
    $requestNom = $db->prepare('SELECT * FROM accounts WHERE nom = :nom and prenom = :prenom');
    $requestNom->execute(array(':nom' => $nom, ':prenom' => $prenom));
    $personne_cherche = $requestNom->fetch(PDO::FETCH_ASSOC);

    if ($personne_cherche)
        return true;
    
    return false;
}

function verifAncienPassword($id, $password)
{
    $db = connectionDB();
    
    $requestNom = $db->prepare('SELECT * FROM accounts WHERE id=:id and password=:password');
    $requestNom->execute(array(':id' => $id, ':password' => $password));
    $personne_cherche = $requestNom->fetch(PDO::FETCH_ASSOC);
    
    if ($personne_cherche)
        return true;
    
    return false;
}

function dejaContact($id_users, $id_contact)
{
    $db = connectionDB();
    
    $request = $db->prepare('SELECT * FROM utilisateurscontact WHERE  id_users = :id_users AND id_contact = :id_contact');
    $request->execute(array(':id_users' => $id_users, ':id_contact' => $id_contact));
    $result = $request->fetch(PDO::FETCH_ASSOC);
    
    if ($result)
        return true;
    
    return false;
}

function inscription($nom, $prenom, $email, $password)
{
    $db = connectionDB();

    $request = $db->prepare('INSERT INTO accounts(nom, prenom, email, password) VALUES (:nom, :prenom,  :email, :password)');
    $request->execute(array(':nom' => $nom, ':prenom' => $prenom, ':email' => $email, ':password' => $password));
}

function ajouterContact($id_users, $id_contact)
{
    $db = connectionDB();
    
    $request = $db->prepare('INSERT INTO utilisateurscontact VALUES (:id_users, :id_contact)');
    $request->execute(array(':id_users' => $id_users, ':id_contact' => $id_contact));
}

function nbContact($id_users)
{
    $db = connectionDB();
    
    $request = $db->prepare('SELECT count(*) AS i FROM utilisateurscontact WHERE id_users=:id_users');
    $request->execute(array(':id_users' => $id_users));
    $nbContact = $request->fetch(PDO::FETCH_ASSOC);
    
    return $nbContact;
}

function modifierCompte($entree, $valeur, $id)
{
     $db = connectionDB();
     
     $request = $db->prepare("UPDATE accounts SET $entree = :valeur WHERE id =:id;");
     $request->execute(array(':valeur' => $valeur, ':id' => $id));
}
function listeEvenementJour($id_users, $date)
{
    $db = connectionDB();
    $request = $db->prepare('SELECT titre, lieu, dureeEvenement, description FROM evenement WHERE id_users = :id AND dateEvenement = :dateEvenement');
   $request->execute(array(':id' => $id_users, ':dateEvenement' => $date));

   $resultat = $request->fetchAll();
  
   return $resultat;
}

function evenementValide($id_users, $date, $titre)
{
    $db = connectionDB();

    $request = $db->prepare('SELECT * FROM evenement WHERE id_users = :id_users AND dateEvenement = :date AND titre = :titre');
    $request->execute(array(':id_users' => $id_users, ':date' => $date, ':titre' => $titre));
    $res = $request->fetch(PDO::FETCH_ASSOC);
    
    if ($res)
        return false;
    
    return true;
}

function ajouterEvenement($id_users, $date, $titre, $lieu, $duree, $description)
{
    $db = connectionDB();
    
    $request = $db->prepare('INSERT INTO evenement(id_users, titre, dateEvenement, lieu, dureeEvenement, description) VALUES (:id_users, :titre, :date, :lieu, :duree, :description)');
    $request->execute(array(':id_users' => $id_users, ':titre' => $titre, ':date' => $date, ':lieu' => $lieu, ':duree' => $duree, 'description' => $description));
}

function getEvenementUsers($id_users)
{
    $db = connectionDB();
    
    $request = $db->prepare('SELECT titre, dateEvenement, lieu, dureeEvenement, description
                                            FROM evenement
                                            WHERE id_users = :id_users
                                            ORDER BY dateEvenement');
    $request->execute(array(':id_users' => $id_users));
    $res = $request->fetchAll();
    return $res;
}

function getNombreEvenementUsers($id_users)
{
    $db = connectionDB();
    
    $request = $db->prepare('SELECT count(*) AS i FROM evenement
                                              WHERE id_users = :id_users ORDER BY dateEvenement');
    $request->execute(array(':id_users' => $id_users));
    $res = $request->fetch(PDO::FETCH_ASSOC);
    
    return $res['i'];
}

function supprimerEvenement($id_users, $date, $titre)
{
     $db = connectionDB();
     $request = $db->prepare('DELETE FROM evenement WHERE id_users = :id_users AND dateEvenement = :date AND titre = :titre');
     $request->execute(array(':id_users' => $id_users, ':date' => $date, ':titre' => $titre));
}
?>