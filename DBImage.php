<?php

/**
 * Charger/enregistrer une image dans une BD MySQL
 * @author Fobec 2011
 */
class DBImage
{

    /**
     * Sauver une image
     * @param string $filename nom du fichier image
     * @param string $name nom de l'image dans la table
     */
    public function write($filename, $name)
    {
        /**
         * Charger le fichier
         */
        if (!file_exists($filename))
        {
            throw new Exception("File $filename not found !!!");
        }
        $fp = fopen($filename, 'r');
        $data = fread($fp, filesize($filename));
        $buf = addslashes($data);
        fclose($fp);
        /**
         * Enregistrer dans la table
         */
        $db = connectionDB();
        $request = $db->prepare('INSERT INTO tbl_image (IMG_NAME, IMG_STREAM) VALUES (:nom, :buf)');
        $request->execute(array(':nom' => $name, ':buf' => $buf));
    }

    /**
     * Charger une image
     * @param string $name nom de l'image dans la table
     * @return 
     */
    public function read($name)
    {
        $db = connectionDB();
        $request = $db->prepare('SELECT IMG_STREAM from tbl_image WHERE IMG_NAME= :name)');
        $request->execute(array(':name' => $name));
        $image = $requestNom->fetch(PDO::FETCH_ASSOC);

        return $image;
    }
}

?>
