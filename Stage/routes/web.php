<?php



use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Admin 
Route::get('/',\App\Http\Controllers\AdminController::class . '@index');
Route::post('/log_admin',\App\Http\Controllers\AdminController::class . '@log_admin');
Route::get('/logout',\App\Http\Controllers\AdminController::class . '@logout');


// crud divers depense 

Route::get('/formaffectation',\App\Http\Controllers\AffectationController::class . '@form');
Route::get('/listeAffectation',\App\Http\Controllers\AffectationController::class . '@listeAffectation');
Route::get('/paginationaffectation/{numero}',\App\Http\Controllers\AffectationController::class . '@pagination');
Route::get('/versmodifaffectation/{id}',\App\Http\Controllers\AffectationController::class . '@versmodifier');
Route::post('/modifieraffectation',\App\Http\Controllers\AffectationController::class . '@modifier');
Route::post('/ajouteraffectation',\App\Http\Controllers\AffectationController::class . '@ajouter');
Route::get('/supprimeraffectation/{id}',\App\Http\Controllers\AffectationController::class . '@supprimer');
Route::post('/rechercheaffectation',\App\Http\Controllers\AffectationController::class . '@recherche');


// crud  service 


Route::get('/formservice',\App\Http\Controllers\ServiceController::class . '@form');
Route::get('/listeService',\App\Http\Controllers\ServiceController::class . '@listeService');
Route::get('/paginationservice/{numero}',\App\Http\Controllers\ServiceController::class . '@pagination');
Route::get('/versmodifservice/{id}',\App\Http\Controllers\ServiceController::class . '@versmodifier');
Route::post('/modifierservice',\App\Http\Controllers\ServiceController::class . '@modifier');
Route::post('/ajouterservice',\App\Http\Controllers\ServiceController::class . '@ajouter');
Route::get('/supprimerservice/{id}',\App\Http\Controllers\ServiceController::class . '@supprimer');
Route::post('/rechercheservice',\App\Http\Controllers\ServiceController::class . '@recherche');



// crud  logistique 
Route::get('/formlogistique',\App\Http\Controllers\LogistiqueController::class . '@form');
Route::get('/listeLogistique',\App\Http\Controllers\LogistiqueController::class . '@listeLogistique');
Route::get('/paginationlogistique/{numero}',\App\Http\Controllers\LogistiqueController::class . '@pagination');
Route::get('/versmodiflogistique/{id}',\App\Http\Controllers\LogistiqueController::class . '@versmodifier');
Route::post('/modifierlogistique',\App\Http\Controllers\LogistiqueController::class . '@modifier');
Route::post('/ajouterlogistique',\App\Http\Controllers\LogistiqueController::class . '@ajouter');
Route::get('/supprimerlogistique/{id}',\App\Http\Controllers\LogistiqueController::class . '@supprimer');
Route::post('/recherchelogistique',\App\Http\Controllers\LogistiqueController::class . '@recherche');


// achat
Route::get('/formachat',\App\Http\Controllers\AchatController::class . '@form');
Route::post('/ajouterachat',\App\Http\Controllers\AchatController::class . '@ajouter');
Route::get('/listeAchat',\App\Http\Controllers\AchatController::class . '@listeAchat');
Route::get('/paginationachat/{numero}',\App\Http\Controllers\AchatController::class . '@pagination');
Route::post('/rechercheachat',\App\Http\Controllers\AchatController::class . '@recherche');


// valider paiment 
Route::post('/log_super_admin',\App\Http\Controllers\ValidationController::class . '@validerAchat');


// stock
Route::get('/listeStock',\App\Http\Controllers\StockController::class . '@listeStock');
Route::get('/paginationstock/{numero}',\App\Http\Controllers\StockController::class . '@pagination');
Route::post('/recherchestock',\App\Http\Controllers\StockController::class . '@recherche');
Route::get('/versmodifstock/{libelle}/{idlogistique}/{idfournisseur}/{prix_unitaire}',\App\Http\Controllers\StockController::class . '@versmodifier');
Route::post('/modifierstock',\App\Http\Controllers\StockController::class . '@modifier');

// recevoir client
Route::get('/client',\App\Http\Controllers\ClientController::class . '@index');
Route::post('/recherchedemande',\App\Http\Controllers\ClientController::class . '@recherchedemande');
Route::get('/paginationdemande/{numero}',\App\Http\Controllers\ClientController::class . '@pagination');


// demande reparation
Route::post('/demande',\App\Http\Controllers\DemandeController::class . '@ajouter');
Route::post('/ajoutervoiture',\App\Http\Controllers\VoitureController::class . '@ajouter');
Route::post('/modifier_demande',\App\Http\Controllers\DemandeController::class . '@modifier');



//reparation
Route::get('/formdevis/{iddemande}',\App\Http\Controllers\DemandeController::class . '@form');
Route::get('/detaildevis/{iddemande}',\App\Http\Controllers\DetailDevisController::class . '@detail');
Route::post('/devisemploye',\App\Http\Controllers\DevisController::class . '@devis_employe');
Route::post('/devisservice',\App\Http\Controllers\DevisController::class . '@devis_service');
Route::post('/devislogistique',\App\Http\Controllers\DevisController::class . '@devis_logistique');
Route::post('/devisprestation',\App\Http\Controllers\DevisController::class . '@devis_prestation');
Route::post('/devisfrais',\App\Http\Controllers\DevisController::class . '@devis_frais');
Route::get('/terminerReparation/{iddemande}',\App\Http\Controllers\DemandeController::class . '@terminer');
Route::post('/valider_reparation',\App\Http\Controllers\ValidationController::class . '@valider_reparation');


//historique reparation
Route::get('/histoRep',\App\Http\Controllers\HistoReparationController::class . '@index');

// supprimer devis 
Route::get('/suppDevisEmploye/{id}',\App\Http\Controllers\DetailDevisController::class . '@suppDevisEmploye');
Route::get('/suppDevisService/{id}',\App\Http\Controllers\DetailDevisController::class . '@suppDevisService');
Route::get('/suppDevisLogistique/{id}',\App\Http\Controllers\DetailDevisController::class . '@suppDevisLogistique');
Route::get('/suppDevisDepense/{id}',\App\Http\Controllers\DetailDevisController::class . '@suppDevisDepense');


//modifier devis 
Route::get('/versmodifDevisService/{id}',\App\Http\Controllers\DetailDevisController::class . '@versmodifDevisService');
Route::get('/versmodifDevisLogistique/{id}',\App\Http\Controllers\DetailDevisController::class . '@versmodifDevisLogistique');
Route::get('/versmodifDevisFrais/{id}',\App\Http\Controllers\DetailDevisController::class . '@versmodifDevisFrais');
Route::get('/versmodifDevisPrestation/{id}',\App\Http\Controllers\DetailDevisController::class . '@versmodifDevisPrestation');
Route::post('/modifierDevisService',\App\Http\Controllers\DetailDevisController::class . '@modifierDevisService');
Route::post('/modifierDevisLogistique',\App\Http\Controllers\DetailDevisController::class . '@modifierDevisLogistique');
Route::post('/modifierDevisFrais',\App\Http\Controllers\DetailDevisController::class . '@modifierDevisFrais');
Route::post('/modifierDevisPrestation',\App\Http\Controllers\DetailDevisController::class . '@modifierDevisPrestation');


// valider Devis 
Route::get('/validerDevis',\App\Http\Controllers\ValidationController::class . '@validerDevis');


// vente 
Route::get('/formvente',\App\Http\Controllers\VenteController::class . '@form');
Route::get('/listeVente',\App\Http\Controllers\VenteController::class . '@listeVente');
Route::get('/paginationvente/{numero}',\App\Http\Controllers\VenteController::class . '@pagination');
Route::post('/ajoutervente',\App\Http\Controllers\VenteController::class . '@ajouter');
Route::post('/recherchevente',\App\Http\Controllers\VenteController::class . '@recherche');
Route::post('/valider_vente',\App\Http\Controllers\ValidationController::class . '@validerVente');


// paiement Devis
Route::get('/paiementDevis/{id}',\App\Http\Controllers\ValidationController::class . '@paiementDevis');


// facture 
Route::get('/exporterFacture/{iddemande}/{prix_final}/{control}',\App\Http\Controllers\FacturationController::class . '@exporter');
Route::get('/listeFacture',\App\Http\Controllers\FacturationController::class . '@listeFacture');
Route::get('/paginationfacture/{numero}',\App\Http\Controllers\FacturationController::class . '@pagination');
Route::post('/recherchefacture',\App\Http\Controllers\FacturationController::class . '@recherche');



// fournisseur
Route::post('/ajouterfournisseur',\App\Http\Controllers\AchatController::class . '@ajouterfournisseur');


// ajout logistique usage
Route::post('/ajoutLogistiqueUsage',\App\Http\Controllers\StockUsageController::class . '@ajouter');
Route::get('/listeStockUsage',\App\Http\Controllers\StockUsageController::class . '@listeStockUsage');
Route::get('/paginationstockUsage/{numero}',\App\Http\Controllers\StockUsageController::class . '@pagination');
Route::post('/recherchestockUsage',\App\Http\Controllers\StockUsageController::class . '@recherche');


// statistiques efficacite 
Route::get('/listeEfficacite',\App\Http\Controllers\EfficaciteController::class . '@listeEfficacite');
Route::get('/paginationefficacite/{numero}',\App\Http\Controllers\EfficaciteController::class . '@pagination');
Route::post('/rechercheefficacite',\App\Http\Controllers\EfficaciteController::class . '@recherche');


// statistique chiffre
Route::get('/listeStatistique',\App\Http\Controllers\StatistiqueController::class . '@listeStatistique');
Route::post('/recherchestatistiques',\App\Http\Controllers\StatistiqueController::class . '@recherche');


// caisse principale
Route::post('/ajout_caisse',\App\Http\Controllers\CaisseController::class . '@ajouter');
Route::get('/listeCaisse/{indice}',\App\Http\Controllers\CaisseController::class . '@listeCaisse');
Route::get('/paginationcaisse/{numero}/{indice}',\App\Http\Controllers\CaisseController::class . '@pagination');
Route::post('/recherchecaisse',\App\Http\Controllers\CaisseController::class . '@recherche');

// caisse Mvola 
Route::post('/ajout_caisse',\App\Http\Controllers\CaisseController::class . '@ajouter');
Route::get('/listeCaisse/{indice}',\App\Http\Controllers\CaisseController::class . '@listeCaisse');
Route::get('/paginationcaisse/{numero}/{indice}',\App\Http\Controllers\CaisseController::class . '@pagination');
Route::post('/recherchecaisse',\App\Http\Controllers\CaisseController::class . '@recherche');


// caisse Banque
Route::post('/ajout_caisse',\App\Http\Controllers\CaisseController::class . '@ajouter');
Route::get('/listeCaisse/{indice}',\App\Http\Controllers\CaisseController::class . '@listeCaisse');
Route::get('/paginationcaisse/{numero}/{indice}',\App\Http\Controllers\CaisseController::class . '@pagination');
Route::post('/recherchecaisse',\App\Http\Controllers\CaisseController::class . '@recherche');



// demande rendez vous 
Route::get('/suggest/{iddemande}',\App\Http\Controllers\DemandeRdvController::class . '@suggest');
Route::get('/reserve/{iddemande}/{date}/{datefin}',\App\Http\Controllers\DemandeRdvController::class . '@reserve');

// caisse 
Route::post('/versmodifcaisse',\App\Http\Controllers\CaisseController::class . '@versmodifier');
Route::post('/modifiercaisse',\App\Http\Controllers\CaisseController::class . '@modifier');

// tableau de bord 
Route::get('/verstableaudebord',\App\Http\Controllers\TableauDeBordController::class . '@liste');
Route::post('/recherchetableaudebord',\App\Http\Controllers\TableauDeBordController::class . '@recherche');


// paiement facture 

Route::post('/verspaiementfacture',\App\Http\Controllers\FacturationController::class . '@verspaiement');
Route::post('/paiementfacture',\App\Http\Controllers\FacturationController::class . '@paiement');


// mouvement facture 
Route::get('/mouvementfacture/{idfacture}',\App\Http\Controllers\MouvementFactureController::class . '@mouvementfacture');
Route::post('/recherchemouvementfacture',\App\Http\Controllers\MouvementFactureController::class . '@recherche');


// client 
Route::get('/formclient',\App\Http\Controllers\ClientController::class . '@form');
Route::get('/listeClient',\App\Http\Controllers\ClientController::class . '@listeClient');
Route::get('/paginationclient/{numero}',\App\Http\Controllers\ClientController::class . '@pagination');
Route::get('/versmodifclient/{id}',\App\Http\Controllers\ClientController::class . '@versmodifier');
Route::post('/modifierclient',\App\Http\Controllers\ClientController::class . '@modifier');
Route::post('/ajouterclient',\App\Http\Controllers\ClientController::class . '@ajouter');
Route::get('/supprimerclient/{id}',\App\Http\Controllers\ClientController::class . '@supprimer');
Route::post('/rechercheclient',\App\Http\Controllers\ClientController::class . '@recherche');


// voiture
Route::get('/formvoiture',\App\Http\Controllers\VoitureController::class . '@form');
Route::get('/listeVoiture',\App\Http\Controllers\VoitureController::class . '@listeVoiture');
Route::get('/paginationvoiture/{numero}',\App\Http\Controllers\VoitureController::class . '@pagination');
Route::get('/versmodifvoiture/{id}',\App\Http\Controllers\VoitureController::class . '@versmodifier');
Route::post('/modifiervoiture',\App\Http\Controllers\VoitureController::class . '@modifier');
Route::post('/ajoutervoiture',\App\Http\Controllers\VoitureController::class . '@ajouter');
Route::get('/supprimervoiture/{id}',\App\Http\Controllers\VoitureController::class . '@supprimer');
Route::post('/recherchevoiture',\App\Http\Controllers\VoitureController::class . '@recherche');



// mouvement_voiture 
Route::get('/listeMouvement_voiture',\App\Http\Controllers\Mouvement_voitureController::class . '@listeMouvement_voiture');
Route::get('/paginationmouvement_voiture/{numero}',\App\Http\Controllers\Mouvement_voitureController::class . '@pagination');
Route::post('/recherchemouvement_voiture',\App\Http\Controllers\Mouvement_voitureController::class . '@recherche');
Route::post('/ajoutermouvement_voiture',\App\Http\Controllers\Mouvement_voitureController::class . '@ajouter');
Route::post('/sortir_voiture',\App\Http\Controllers\Mouvement_voitureController::class . '@sortir');


// journal caisse 
Route::get('/journalCaisse',\App\Http\Controllers\CaisseController::class . '@journal');

// choisir voiture 
Route::get('/choisir/{id}',\App\Http\Controllers\ChoixController::class . '@listeVoiture');
Route::get('/paginationchoisir/{numero}',\App\Http\Controllers\ChoixController::class . '@pagination');
Route::post('/recherchechoisir',\App\Http\Controllers\ChoixController::class . '@recherche');
Route::post('/selectionner',\App\Http\Controllers\ChoixController::class . '@selectionner');

//form demande 
Route::get('/formdemande',\App\Http\Controllers\DemandeController::class . '@formdemande');

// taux utilisation
Route::get('/taux',\App\Http\Controllers\StatistiqueController::class . '@taux');

// parc
Route::get('/listeParc',\App\Http\Controllers\ParcAutoController::class . '@listeParc');
Route::post('/rechercheparc',\App\Http\Controllers\ParcAutoController::class . '@recherche');
Route::get('/calendrierParc',\App\Http\Controllers\ParcAutoController::class . '@calendrier');
Route::post('/recherchecalendrier',\App\Http\Controllers\ParcAutoController::class . '@recherchecalendrier');
Route::get('/paginationparc/{numero}',\App\Http\Controllers\ParcAutoController::class . '@pagination');

// rendez vous 
Route::get('/versrdv',\App\Http\Controllers\DemandeRdvController::class . '@vers');
Route::post('/ajout_rdv',\App\Http\Controllers\DemandeRdvController::class . '@ajout');
Route::get('/annuler/{iddemande}',\App\Http\Controllers\DemandeRdvController::class . '@annuler');