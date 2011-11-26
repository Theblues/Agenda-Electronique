CREATE TABLE accounts (id serial primary key, nom varchar(32), prenom varchar(32),  email varchar(32), password varchar(8) );

CREATE TABLE accounts_access (
                id int primary key,
                gmlevel int
                );

CREATE TABLE contact (id_users int primary key, id_contact  int, primary key(id_users,id_contact));
		
CREATE TABLE evenement (id_evenement serial, id_users int, titre varchar(32), dateEvenement date, lieu varchar(32), heure_debut int, heure_fin int, description varchar(255), primary key(id_evenement, id_users));