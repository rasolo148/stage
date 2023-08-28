<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\demande_reparation;
use App\Models\vente;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\caisse;
use App\Models\affectation;
use App\Models\reparation_logistique;

class ValidationController extends Controller
{

    public static function logg($mdp, $role)
    {
        $login = collect(\DB::select('select count(*) as isa from admin where password = ? and role=?', [$mdp, $role]))->first();
        return $login->isa;
    }

    //login admin
    public function validerAchat(Request $request)
    {
        $login = self::logg(request('mdp'), "admin");
        if ($login == 0) {
            session(['numero' => request('idachat')]);
            return redirect()->back()->with('error', 'Mot de passe incorrect');
        } else {
            $id = DB::table("v_achat")->where("v_achat.idachat", request('idachat'));

            $id->update([
                'etat_paiement' => '1'
            ]);

            $achat =  DB::table("v_achat")->where("v_achat.idachat", request('idachat'))->first();

            $affectation = affectation::where("libelle", "PIECES DETACHEES")->first();

            $data_caisse = [
                'idaffectation' => $affectation->idaffectation,
                'reference' => $achat->libelle . ' ' . $achat->reference,
                'libelle' => "achat pieces",
                'type_mouvement' => "sortie",
                'type_paiement' => $achat->type_paiement,
                'montant' => $achat->quantiter * $achat->prix_unitaire,
                'date' => $achat->date,
            ];
            caisse::create($data_caisse);

            return redirect("listeAchat")->with('success', 'L\'achat a été validé avec succès !');
        }
    }

    public function validerDevis(Request $request)
    {
        $id = demande_reparation::find(request('iddemande'));
        $logistique = reparation_logistique::where('iddemande',request('iddemande'))->get();
    
        $errors = []; // Initialize an array to store errors
    
        foreach ($logistique as $liste) {
            $query = collect(DB::select("SELECT v1.quantite_restante, l.libelle FROM logistique l JOIN v_stock_final v1 USING(idlogistique) JOIN fournisseur f USING(idfournisseur) WHERE idlogistique=? AND idfournisseur=?", [$liste->idlogistique, $liste->idfournisseur]))->first();

            if ($liste->quantite > $query->quantite_restante) {
                $errors[] = 'La quantité demandée (' . $liste->quantite . ') pour "' . $query->libelle . '" dépasse la quantité disponible en stock. Quantité restante : ' . $query->quantite_restante;
            }
        }
    
        if (!empty($errors)) {
             return redirect()->back()->withErrors($errors);
        } 
        else 
        {
            $id->update([
                'etat_reparation' => '1',
                'prix_final' => request('prix_final'),
            ]);
    
            return redirect()->back();
        }
    }
    

    public function validerVente(Request $request)
    {
        $login = self::logg(request('mdp'), "admin");
        if ($login == 0) {
            session(['numero' => request('idvente')]);
            return redirect()->back()->with('error', 'Mot de passe incorrect');
        } else {
            $id = vente::find(request('idvente'));
            $id->update([
                'etat_paiement' => '1'
            ]);
            
            $vente =  DB::table("v_vente")->where("v_vente.idvente", request('idvente'))->first();

            $affectation = affectation::where("libelle", "VENTE DE PIECES")->first();

            $data_caisse = [
                'idaffectation' => $affectation->idaffectation,
                'reference' => $vente->libelle,
                'libelle' => "vente pièces",
                'type_mouvement' => "entree",
                'type_paiement' => $vente->type_paiement,
                'montant' => $vente->quantite * $vente->prix_unitaire,
                'date' => $vente->date,
            ];
            caisse::create($data_caisse);

            return redirect()->back()->with('success', 'La vente a été validée avec succès !');
        }
    }

}
