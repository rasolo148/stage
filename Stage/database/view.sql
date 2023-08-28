

create or replace view v_depenses as 
select d.* , cd.categorie , e.nom , e.prenom from categorie_depense cd join divers_depense d using(idcategorie_depense) join employe e using(idemploye);



CREATE OR REPLACE VIEW v_achat AS 
SELECT a.*, l.libelle, l.type_logistique, l.marge_beneficiaire,f.nomfournisseur,f.lieu,
       CASE
           WHEN a.etat_paiement = '1' THEN 'validé'
           ELSE 'non validé'
       END AS etat
FROM logistique l JOIN achat a USING(idlogistique) join fournisseur f using(idfournisseur);


create or replace view v_stock as
select sum(quantiter) as total , idlogistique , idfournisseur , prix_unitaire from v_achat where etat_paiement='1' group by idlogistique , idfournisseur;


create or replace view v_demande as 
SELECT * FROM demande_reparation d 
JOIN voiture v USING (idvoiture) 
JOIN client c USING (idclient);


create or replace view v_vente as
select v.* , c.nom , l.libelle , l.type_logistique from client c join vente v using(idclient) join logistique l using(idlogistique);


create or replace view v_total_vente as 
select idlogistique , idfournisseur , sum(quantite) as total from vente where etat_paiement = '1'  group by idlogistique,idfournisseur ;

create or replace view v_total_logistique as 
select idlogistique , idfournisseur , sum(quantite) as total from reparation_logistique where etat_paiement = '1'  group by idlogistique,idfournisseur ;



create or replace view v_stock_final as 
SELECT
    vs.idlogistique,
    vs.idfournisseur,
    vs.prix_unitaire,
    vs.total,
    COALESCE(v.total,0) as vente,
    COALESCE(r.total, 0) as reparation,
    vs.total -  COALESCE(v.total,0) -  COALESCE(r.total,0) as quantite_restante
FROM
    v_stock AS vs
LEFT JOIN
    v_total_logistique AS r ON vs.idlogistique = r.idlogistique
                               AND vs.idfournisseur = r.idfournisseur         
LEFT JOIN
    v_total_vente AS v ON vs.idlogistique = v.idlogistique
             AND vs.idfournisseur = v.idfournisseur
GROUP BY
    vs.idlogistique,
    vs.idfournisseur;


    
create or replace view v_stock_final_detail as 
SELECT
        vs.idlogistique,
        vs.idfournisseur,
        vs.quantite_restante,
        vs.prix_unitaire,
        l.libelle,
        l.type_logistique,
        l.marge_beneficiaire,
        f.nomfournisseur,
        f.lieu
    FROM v_stock_final AS vs
    JOIN logistique AS l ON vs.idlogistique = l.idlogistique
    INNER JOIN fournisseur AS f ON vs.idfournisseur = f.idfournisseur;



DELIMITER //
CREATE or replace  FUNCTION format_facture_id(idfacture INT)
RETURNS VARCHAR(10)
BEGIN
    DECLARE current_year CHAR(4);
    SET current_year = DATE_FORMAT(CURDATE(), '%Y');
    RETURN CONCAT(LPAD(idfacture, 3, '0'), '/', RIGHT(current_year, 2));
END //
DELIMITER ;



create or replace view v_facture as 
SELECT f.datemouvement,f.idfacture,f.date,dr.iddemande,dr.nom,dr.pseudo,dr.prix_final AS montant_total, COALESCE(SUM(pf.montant), 0) AS montant_paye, (dr.prix_final - COALESCE(SUM(pf.montant), 0)) AS reste_a_payer,
       CASE WHEN dr.prix_final - COALESCE(SUM(pf.montant), 0) = 0 THEN 1 ELSE 0 END AS est_paye
FROM facture f
JOIN v_demande dr ON f.iddemande = dr.iddemande
LEFT JOIN paiementfacture pf ON f.idfacture = pf.idfacture
GROUP BY f.idfacture;


----temps moyen reparation----

create or replace view v_temps_moyen as
SELECT c.nom, c.contact,dr.idvoiture,v.immatriculation, v.marque, v.modele,
    IF(AVG(TIMESTAMPDIFF(MINUTE, dr.datedebut, dr.datefin)) >= 1440,
        CONCAT(FLOOR(AVG(TIMESTAMPDIFF(MINUTE, dr.datedebut, dr.datefin)) / 1440), ' jours ', FLOOR(MOD(AVG(TIMESTAMPDIFF(MINUTE, dr.datedebut, dr.datefin)), 1440) / 60), ' heures et ', CAST(MOD(AVG(TIMESTAMPDIFF(MINUTE, dr.datedebut, dr.datefin)), 60) AS SIGNED), ' minutes'),
        IF(MOD(AVG(TIMESTAMPDIFF(MINUTE, dr.datedebut, dr.datefin)), 60) = 0,
            CONCAT(FLOOR(AVG(TIMESTAMPDIFF(MINUTE, dr.datedebut, dr.datefin)) / 60), ' heures'),
            CONCAT(FLOOR(AVG(TIMESTAMPDIFF(MINUTE, dr.datedebut, dr.datefin)) / 60), ' heures et ', CAST(MOD(AVG(TIMESTAMPDIFF(MINUTE, dr.datedebut, dr.datefin)), 60) AS SIGNED), ' minutes')
        )
    ) AS temps_moyen_reparation
FROM demande_reparation dr
JOIN voiture v ON v.idvoiture = dr.idvoiture
JOIN client c ON c.idclient = v.idclient
WHERE etat_reparation = '2'
GROUP BY dr.idvoiture;

--- statistiques 

-- DELIMITER //

create or replace view v_caisse as 
select 
    c.*,
    SUM(CASE WHEN c.type_mouvement = 'entree' THEN c.montant ELSE -c.montant END) OVER (PARTITION BY c.type_paiement ORDER BY c.datemouvement) AS solde,
    cd.categorie, 
    cd.idcategorie_depense, 
    a.libelle as affectation 
from categorie_depense cd 
join affectation a using(idcategorie_depense) 
join caisse c using(idaffectation);

DELIMITER //

CREATE or replace PROCEDURE p_statistiques(
    IN desired_year INT,
    IN desired_month INT
)
BEGIN
    SELECT
        all_months.year,
        all_months.month,
        COALESCE(expenses.total_expenses, 0) AS total_expenses,
        COALESCE(revenue.total_revenue, 0) AS total_revenue,
        COALESCE(revenue.total_revenue, 0) - COALESCE(expenses.total_expenses, 0) AS profit
    FROM (
        SELECT YEAR(date) AS year, MONTH(date) AS month
        FROM (
            SELECT DISTINCT DATE(CONCAT(desired_year, '-', LPAD(month, 2, '00'), '-01')) AS date
            FROM (
                SELECT 1 AS month UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6
                UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10 UNION SELECT 11 UNION SELECT 12
            ) months
        ) calendar
    ) all_months
    LEFT JOIN (
        SELECT YEAR(date) AS year, MONTH(date) AS month, SUM(montant) AS total_expenses
        FROM caisse
        WHERE type_mouvement = 'sortie' AND YEAR(date) = desired_year
        GROUP BY year, month
    ) AS expenses ON all_months.year = expenses.year AND all_months.month = expenses.month
    LEFT JOIN (
        SELECT YEAR(date) AS year, MONTH(date) AS month, SUM(montant) AS total_revenue
        FROM caisse
        WHERE type_mouvement = 'entree' AND YEAR(date) = desired_year
        GROUP BY year, month
    ) AS revenue ON all_months.year = revenue.year AND all_months.month = revenue.month
    WHERE (desired_month IS NULL OR all_months.month = desired_month);
END;

//
DELIMITER ;

DELIMITER //
CREATE PROCEDURE sp_tableau_bord(IN p_mois INT, IN p_annee INT, IN p_idcategorie_depense INT)
BEGIN
    DROP TEMPORARY TABLE IF EXISTS temp_dates;
    CREATE TEMPORARY TABLE temp_dates (mois INT, annee INT);
    INSERT INTO temp_dates VALUES (p_mois, p_annee);

    SELECT
        cd.categorie,
        a.libelle,
        a.idcategorie_depense,
        a.idaffectation,
        COALESCE(SUM(c.montant), 0) AS montant_total,
        d.annee,
        d.mois
    FROM
        affectation a
    CROSS JOIN
        temp_dates d
    LEFT JOIN
        v_caisse c ON a.idaffectation = c.idaffectation AND YEAR(c.date) = d.annee AND MONTH(c.date) = d.mois
    LEFT JOIN
        categorie_depense cd ON a.idcategorie_depense = cd.idcategorie_depense
    WHERE
        (p_idcategorie_depense IS NULL OR a.idcategorie_depense = p_idcategorie_depense)
    GROUP BY
        a.idaffectation,
        cd.idcategorie_depense,
        d.annee,
        d.mois
    ORDER BY
        a.idaffectation ASC,
        d.annee ASC,
        d.mois ASC;
END //
DELIMITER ;


create or replace view v_voiture as 
select * from voiture v join client c using(idclient);


CREATE OR REPLACE VIEW v_parc AS 
SELECT
    np.idnumero_place,
    CASE
        WHEN dr.idnumero_place IS NULL THEN 'Libre'
        WHEN dr.etat_sortie = '1' THEN 'Libre'
        ELSE 'Non libre'
    END AS etat,
    CASE
        WHEN dr.idnumero_place IS NOT NULL AND dr.etat_sortie = '0' THEN v.immatriculation
    END AS immatriculation,
    CASE
        WHEN dr.idnumero_place IS NOT NULL AND dr.etat_sortie = '0' THEN v.marque
    END AS marque,
    CASE
        WHEN dr.idnumero_place IS NOT NULL AND dr.etat_sortie = '0' THEN dr.datedebut
    END AS datedebut,
    CASE
        WHEN dr.idnumero_place IS NOT NULL AND dr.etat_sortie = '0' THEN dr.datefin
    END AS datefin,
    CASE
        WHEN dr.idnumero_place IS NOT NULL AND dr.etat_sortie = '0' THEN dr.description
    END AS description,
    vv.nom,
    dr.date_entree,
    dr.nombre_mecaniciens,
    dr.iddemande,
    dr.date_sortie
FROM (
    SELECT idnumero_place
    FROM numero_place
    ORDER BY idnumero_place ASC
) np
LEFT JOIN (
    SELECT
        dr1.idnumero_place,
        dr1.idvoiture,
        dr1.datedebut,
        dr1.datefin,
        dr1.description,
        dr1.etat_sortie,
        dr1.date_entree,
        dr1.nombre_mecaniciens,
        dr1.iddemande,
        dr1.date_sortie,
        ROW_NUMBER() OVER (PARTITION BY dr1.idnumero_place ORDER BY dr1.datemouvement DESC) AS rn
    FROM demande_reparation dr1
    WHERE dr1.date_entree IS NOT NULL
) dr ON np.idnumero_place = dr.idnumero_place AND dr.rn = 1
LEFT JOIN voiture v ON dr.idvoiture = v.idvoiture
LEFT JOIN v_voiture vv ON v.immatriculation = vv.immatriculation
ORDER BY np.idnumero_place;
