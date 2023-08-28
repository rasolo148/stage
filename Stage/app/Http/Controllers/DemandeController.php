<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\demande_reparation;
use App\Models\employe;
use App\Models\service;
use App\Models\facture;
use Carbon\Carbon;

class DemandeController extends Controller
{

    public function formdemande()
    {
        return view('reparation/formdemande');
    }

    public function ajouter(Request $request)
    {
        $data = [
            'idvoiture' => request('idvoiture'),
            'description' => request('description'),
        ];   
         
        demande_reparation::create($data);
        return redirect('client')->with('success', 'Demande de réparation ajoutée avec succès !');
    }

    public function form()
    {
        $iddemande = request('iddemande');
      
        $listeEmploye = employe::all();
        $listeService = service::all();
        $listeLogistique = DB::select("select l.libelle , l.type_logistique , v1.* , f.nomfournisseur from logistique l join v_stock_final v1 using(idlogistique) join fournisseur f using(idfournisseur)");
        

        $detailLogistique = facture::detailLogistique($iddemande); 
        $totalProduit = facture::calculTotal($detailLogistique);
        $detailService = facture::detailService($iddemande);
        $totalService = facture::calculTotal($detailService);
        
        $total = $totalProduit + $totalService;
        
        $detail = demande_reparation::getDetail($iddemande);
        $estDemandeFacture = facture::estDemandeFacture($iddemande);
        return view('reparation/formdevis', [
            'iddemande' => $iddemande,
            'listeEmploye' => $listeEmploye,
            'listeService' => $listeService,
            'listeLogistique' => $listeLogistique,
            'detailLogistique' => $detailLogistique,
            'detailService' => $detailService,
            'totalProduit' => $totalProduit,
            'totalService' => $totalService,   
            'total' => $total,
            'detail' => $detail,
            'estDemandeFacture' => $estDemandeFacture,
        ]);
    }

    public function terminer()
    {
        $id = demande_reparation::find(request('iddemande'));
        $now = Carbon::now();
        $datenow  = $now->format('Y-m-d H:i:s');

        $id->update([
            'etat_reparation' => '2',
            'datefin' => $datenow
        ]);

        return redirect()->back()->with('', 'Réparation terminée avec succès !');
    }

    public function modifier()
    {
        $id = demande_reparation::find(request('iddemande'));
        $id->update([
            'nombre_mecaniciens' => request('nombre_mecaniciens'),
            'idnumero_place' => request('idnumero_place'),
            'date_entree' => request('date_entree'),
            'datedebut' => request('datedebut'),
            'datefin' => request('datefin'),
        ]);
        return redirect()->back()->with('modification', 'Modification avec succès !');
    }
}
