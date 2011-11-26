CREATE TABLE accounts (
                    id  int(11) unsigned NOT NULL auto_increment primary key,
                    nom varchar(32) NOT NULL default '',
                    prenom varchar(32) NOT NULL default '',
                    email varchar(64) NOT NULL default '',
                    password varchar(8) NOT NULL
                );

CREATE TABLE accounts_access (
                id int(11) unsigned NOT NULL primary key,
                gmlevel TINYINT(3)  unsigned
                );

CREATE TABLE contact (
                id_users int(11) unsigned NOT NULL,
                id_contact int(11) unsigned NOT NULL,
                primary key(id_users,id_contact)
                );

CREATE TABLE evenement (
               id_evenement int(11) unsigned NOT NULL auto_increment,
               id_users int (11) unsigned NOT NULL,
               titre varchar(32) NOT NULL default 'Sans titre',
               dateEvenement date,
                lieu varchar(32),
                   heure_debut int,
                   heure_fin int,
                description varchar(64),
               
               primary key(id_evenement, id_users)
            );