
drop view v_parc;
drop view v_voiture;
drop procedure sp_tableau_bord;
drop procedure p_statistiques;
drop view v_temps_moyen;
drop view v_facture;
drop function format_facture_id;
drop view v_stock_final_detail;
drop view v_stock_final;
drop view v_total_logistique;
drop view v_total_vente;
drop view v_vente;
drop view v_demande;
drop view v_stock;
drop view v_achat;
drop view v_depenses;


drop table caisse;
drop table affectation;
drop table paiementfacture;
drop table facture;
drop table vente;
drop table reparation_logistique;
drop table reparation_service;
drop table demande_reparation;
drop table numero_place;
drop table voiture;
drop table achat;
drop table fournisseur;
drop table logistique;
drop table client;
drop table service;
drop table categorie_depense;
drop table employe;
drop table admin;


create table admin(
idadmin serial,
mail varchar(20),
password varchar(8),
role varchar(9),
img text default null
);


create table employe(
idemploye serial primary key,
nom varchar(20),
prenom varchar(30),
fonction text,
salaire_de_base decimal(10,2),
etat_suppression ENUM('0','1') not null default '0'
);



create table categorie_depense(
idcategorie_depense serial primary key,
categorie text
);



create table service(
idservice int auto_increment primary key,
libelle text,
tarif decimal(10,2),
etat_suppression ENUM('0','1') not null default '0'
);


/*  client  */

create table client(
idclient serial primary key,
nom varchar(30),
contact char(10),
adresse text,
pseudo varchar(20)
);

/* stock logistique */

create table logistique(
idlogistique serial primary key,
libelle text,
type_logistique text,
marge_beneficiaire decimal(4,2),
etat_suppression ENUM('0','1') not null default '0'
);


create table fournisseur(
idfournisseur serial primary key,
nomfournisseur text,
lieu text
);


create table achat(
idachat serial,
idlogistique int references logistique(idlogistique),
idfournisseur int references fournisseur(idfournisseur),
quantiter decimal(5,2),
marque varchar(15),
modele varchar(15),
reference varchar(15),
prix_unitaire decimal(10,2),
type_paiement ENUM('Espece','Mvola','Banque'),
date date default current_date,
etat_paiement ENUM('0','1') not null default '0',
datemouvement datetime default current_timestamp
);

create table voiture(
idvoiture serial primary key,    
idclient int references client(idclient),    
immatriculation text,
marque text,
modele text,
energie varchar(10)
);


create table numero_place(
idnumero_place serial primary key,
numero_place smallint,
datemouvement datetime default current_timestamp
);

INSERT INTO numero_place (numero_place) VALUES
(1), (2), (3), (4), (5),
(6), (7), (8), (9), (10),
(11), (12), (13), (14), (15);



create table demande_reparation(
iddemande serial primary key,
idvoiture int references voiture(idvoiture),
description text,
prix_final decimal(10,2),
nombre_mecaniciens int default 0,
datedebut  datetime,
datefin datetime,
date_entree datetime,
date_sortie datetime,
etat_reparation ENUM('0','1','2') not null default '0',
idnumero_place smallint references numero_place(idnumero_place),
etat_sortie ENUM('0','1') default '0',
type_demande ENUM('normal','rdv') default 'normal',
datemouvement datetime default current_timestamp
);

INSERT INTO demande_reparation (
    idvoiture,
    description,
    prix_final,
    nombre_mecaniciens,
    datedebut,
    datefin,
    date_entree,
    date_sortie,
    etat_reparation,
    idnumero_place,
    etat_sortie,
    type_demande) VALUES (1,'Réparation suite à un accident',
    0,2,'2023-08-24','2023-08-27','2023-08-24',NULL,'0',4,'0','rdv');


-- ALTER TABLE demande_reparation ADD type_demande ENUM('normal','rdv') default 'normal';

create table reparation_service(
idreparation_service serial,    
iddemande int references demande_reparation(iddemande),
idservice int references service(idservice),
etat_suppression ENUM('0','1') not null default '0'
);


create table reparation_logistique(
idreparation_logistique serial,    
iddemande int references demande_reparation(iddemande),
idlogistique int references logistique(idlogistique),
idfournisseur int references fournisseur(idfournisseur),
prix_unitaire decimal(10,2),
quantite decimal(5,2),
etat_paiement ENUM('0','1') not null default '0'
);


create table vente(
idvente serial primary key,    
idclient int references client(idclient),
idlogistique int references logistique(idlogistique),
idfournisseur int references fournisseur(idfournisseur),
prix_unitaire decimal(10,2),
quantite decimal(5,2),
type_paiement ENUM('Espece','Mvola','Banque'),
date date default current_date,
etat_paiement ENUM('0','1') not null default '0',
datemouvement datetime default current_timestamp
);


CREATE TABLE facture (
    idfacture INT AUTO_INCREMENT PRIMARY KEY,
    iddemande int references demande_reparation(iddemande),
    date DATE DEFAULT CURRENT_DATE,
    montant_total DECIMAL(10,2),
    datemouvement datetime default current_timestamp
);

create table paiementfacture(
idpaiementfacture serial primary key,
idfacture int references facture(idfacture),
montant decimal(10,2),
type_paiement ENUM('Espece','Mvola','Banque'),
date date default current_date,
datemouvement datetime default current_timestamp
);


create table affectation(
idaffectation serial primary key,
libelle text,
idcategorie_depense int references categorie_depense(idcategorie_depense),
type_mouvement ENUM('entree','sortie')
);


create table caisse(
idcaisse serial primary key,
type_mouvement ENUM('entree','sortie'),
idaffectation int references affectation(idaffectation),
reference text,
libelle text,
type_paiement ENUM('Espece','Mvola','Banque'),
montant decimal(10,2),
date date default current_date,
datemouvement datetime default current_timestamp
);



