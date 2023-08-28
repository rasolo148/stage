
insert into admin(mail,password,role) values ('hardi','hardi','admin');

insert into admin(mail,password,role) values ('tojo','tojo','atelier');


-- Insérer des données de test dans la table employe (employés du garage)
INSERT INTO employe (nom, prenom, fonction, salaire_de_base, etat_suppression)
VALUES
    ('Dupont', 'Jean', 'Mécanicien', 2500.00, '0'),
    ('Martin', 'Sophie', 'Carrossier', 2300.00, '0'),
    ('Dubois', 'Pierre', 'Vendeur', 2000.00, '0'),
    ('Lefevre', 'Marie', 'Réceptionniste', 1800.00, '0'),
    ('Robert', 'Paul', 'Technicien', 2200.00, '0');



INSERT INTO categorie_depense (categorie) VALUES ('FRAIS DE SIEGE');
INSERT INTO categorie_depense (categorie) VALUES ('FRAIS D''ATELIER');
INSERT INTO categorie_depense (categorie) VALUES ('RECETTES');


INSERT INTO service (libelle, tarif, etat_suppression)
VALUES
    ('Réparation moteur', 300.00, '0'),
    ('Carrosserie', 200.00, '0'),
    ('Entretien général', 150.00, '0'),
    ('Diagnostic électronique', 250.00, '0'),
    ('Révision périodique', 180.00, '0'),
    ('Pneumatique', 120.00, '0'),
    ('Lavage et nettoyage', 80.00, '0'),
    ('Climatisation', 200.00, '0'),
    ('Dépannage routier', 280.00, '0');


insert into client(nom,contact,adresse,pseudo) values ('hardi tojoniaina','0341864576','adresse1','hardi') , ('tojo hajarisoa','0322185182','adresse2','tojo');


INSERT INTO logistique (libelle, type_logistique, marge_beneficiaire)
VALUES
    ('Pneus', 'Pièces détachées', 0.2),
    ('Huile moteur', 'Consommables', 0.3),
    ('Batteries', 'Pièces détachées', 0.25);


insert into fournisseur(nomfournisseur,lieu) values ('market','anosizato') , ('test','isotry') , ('test1','ivandry');


INSERT INTO achat (idlogistique, idfournisseur, quantiter,marque, modele, reference, prix_unitaire,type_paiement,etat_paiement)
VALUES
    (1, 1, 100,'Michelin', 'XWX-101', 'MI-PN-101', 80.00,'Espece','1'),
    (2, 2, 50,'Castrol', 'SYN-5W30', 'CA-ML-202', 35.100,'Espece','0'),
    (3, 1, 80,'Bosch', 'BAT-12V', 'BS-BT-150', 50.00,'Mvola','1');


INSERT INTO voiture (idclient, immatriculation, marque, modele,energie)
VALUES
    (1, 'AB-123-CD', 'Peugeot', '208','Essence'),
    (2, 'EF-456-GH', 'Renault', 'Clio','Diesel'),
    (3, 'IJ-789-KL', 'Volkswagen', 'Golf','Essence');


insert into affectation(libelle,idcategorie_depense,type_mouvement) values ('FRAIS DEPLACEMENT',1,'sortie') , ('FOURNITURE DE BUREAU',1,'sortie') , ('INVESTISSEMENT GARAGE',3,'entree') , ('ENTRETIEN MACHINE OUTILLAGE',2,'sortie') , ('PIECES DETACHEES',2,'sortie') , ('CANTINE',1,'sortie') , ('ACCOMPTE FACTURE',3,'entree') , ('SOLDE TOUT COMPTE FACTURE',3,'entree') , ('SOLDE FACTURE',3,'entree') , ('VENTE DE PIECES',3,'entree') ;

