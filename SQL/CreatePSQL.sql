CREATE TABLE accounts (id serial primary key, nom varchar(32), prenom varchar(32),  email varchar(32), password varchar(8) );

CREATE TABLE accounts_access (
                id int primary key,
                gmlevel int
                );

CREATE TABLE utilisateurscontact (                id_users int primary key,                id_contact  int                );
		
CREATE TABLE evenementStruct (               id_evenement serial ,               id_users int,               titre varchar(32),               dateEvenement date,    primary key(id_evenement, id_users)            );
               
CREATE TABLE evenementDetail (            id_evenement serial primary key,            lieu varchar(32),            dureeEvenement int,            description varchar(64)            );