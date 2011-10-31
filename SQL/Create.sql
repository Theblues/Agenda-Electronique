CREATE TABLE accounts (
                    id  int(11) unsigned NOT NULL auto_increment primary key,
                    nom varchar(32) NOT NULL default '',
                    prenom varchar(32) NOT NULL default '',
                    email varchar(32) NOT NULL default '',
                    password varchar(8) NOT NULL
                );

CREATE TABLE accounts_access (
                id int(11) unsigned NOT NULL primary key,
                gmlevel TINYINT(3)  unsigned
                );

CREATE TABLE utilisateurscontact (
                id int(11) unsigned NOT NULL primary key,
                id_contact int(11) unsigned NOT NULL
                );

--
-- Structure de la table `tbl_image`
--

/*CREATE TABLE IF NOT EXISTS `tbl_image` (
                --`IMG_NAME` varchar(32) character set utf8 NOT NULL,
         --         `IMG_STREAM` blob NOT NULL,
          --        UNIQUE KEY `IMG_NAME` (`IMG_NAME`)
       --         ) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;*/