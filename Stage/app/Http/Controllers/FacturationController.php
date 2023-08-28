<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\facture;
use App\Models\paiementfacture;
use App\Models\caisse;
use App\Models\affectation;
use App\Models\admin;
use PDF;

class FacturationController extends Controller
{

    public function exporter()
    {
        $iddemande = request('iddemande');
        $control = request('control');
        if ($control == 1) {
            if (!facture::estDemandeFacture($iddemande)) {
                $data = [
                    'iddemande' => $iddemande,
                    'montant_total' => request('prix_final'),
                ];
                facture::create($data);
            }
        }
        $html = facture::genererPDF($iddemande);
        $pdf = PDF::loadHTML($html, ['format' => 'A4']);

        $facture = facture::formatFacture($iddemande);
        $filename = 'facture_reparation_' . $facture->idfacture . '.pdf';
        return $pdf->stream($filename);
    }

    public function listeFacture()
    {
        $bloc = 5;
        $page = request()->query('page', 1); // Valeur par défaut : 1
        $perPage = request()->query('perPage', $bloc); // Valeur par défaut : 10
        $currentPage = 1;

        $liste = DB::table('v_facture')->select('v_facture.*', DB::raw('format_facture_id(v_facture.idfacture) as formatted_idfacture'))->orderBy('v_facture.datemouvement', 'desc')->paginate($perPage, ['*'], 'page', $page);

        $lastPage = $liste->lastPage();

        $listeNumeroPage = range(1, $lastPage);

        return view('facture/Liste', [
            'liste' => $liste,
            'currentPage' => $currentPage,
            'lastPage' => $lastPage,
            'listeNumeroPage' => $listeNumeroPage,
        ]);
    }

    public function pagination(Request $request)
    {
        $bloc = 5;
        $page = request()->query('page', request('numero')); // Valeur par défaut : 1
        $perPage = request()->query('perPage', $bloc); // Valeur par défaut : 10
        $currentPage = request('numero');

        $liste = DB::table('v_facture')->select('v_facture.*', DB::raw('format_facture_id(v_facture.idfacture) as formatted_idfacture'))->orderBy('v_facture.datemouvement', 'desc')->paginate($perPage, ['*'], 'page', $page);

        $lastPage = $liste->lastPage();

        $listeNumeroPage = range(1, $lastPage);

        return view('facture/Liste', [
            'liste' => $liste,
            'currentPage' => request('numero'),
            'lastPage' => $lastPage,
            'listeNumeroPage' => $listeNumeroPage,
        ]);
    }

    public function recherche(Request $request)
    {

        $query = DB::table('v_facture')->select('v_facture.*', DB::raw('format_facture_id(v_facture.idfacture) as formatted_idfacture'));

        if (null !== $request->input('etat')) {
            $query->whereRaw("v_facture.est_paye = ?", [$request->input('etat')]);
        }

        if (null !== $request->input('numero')) {
            $query->whereRaw("format_facture_id(v_facture.idfacture) COLLATE utf8mb4_unicode_ci = ?", [$request->input('numero')]);
        }

        if (null !== $request->input('nom')) {
            $query->where('v_facture.nom', 'like', '%' . $request->input('nom') . '%');
        }

        if (null !== $request->input('date')) {
            $query->where('v_facture.date', '=', $request->input('date'));
        }

        $results = $query->get();
        $lastPage = 3;
        $listeNumeroPage = range(1, $lastPage);
        return view('facture/Liste', [
            'liste' => $results,
            'currentPage' => 1,
            'lastPage' => $lastPage,
            'listeNumeroPage' => $listeNumeroPage,
        ]);
    }

    public function verspaiement()
    {
        // $role = $request->session()->get('role'); 
        $login = admin::logg(request('mdp'), "admin");
        $idfacture = request('idfacture');
        if ($login == 0) {
            session(['numero' => $idfacture]);
            return redirect()->back()->with('error', 'Mot de passe incorrect');
        } else {

            $facture = DB::table('v_facture')
            ->select('v_facture.*', DB::raw('format_facture_id(v_facture.idfacture) as formatted_idfacture'))
            ->where('idfacture', '=', $idfacture) // Remplacez $idfacture par la valeur de l'idfacture que vous voulez filtrer
            ->first();
        
            return view('facture.Paiement', [
                'idfacture' => request('idfacture'),
                'format' => $facture->formatted_idfacture,
                'reste' => $facture->reste_a_payer,
            ]);
        }
      
    }

    public function paiement(Request $request)
    {
        $montant = request('montant');
        $reste = request('reste');
        if ($montant <= 0) {
            return redirect()->back()->with('error', 'Montant invalide');
        } else if ($montant > $reste) {
            return redirect()->back()->with('error', 'Le montant ne doit pas être supérieur au reste à payer de ' . $reste . ' !');
        } else {
            $data = [
                'idfacture' => request('idfacture'),
                'montant' => $montant,
                'type_paiement' => request('type_paiement'),
                'date' => request('date'),
            ];
            paiementfacture::create($data);

            // enregistrer dans la caisse
            $affectation = affectation::where("libelle", "SOLDE TOUT COMPTE FACTURE")->first();

            $data_caisse = [
                'idaffectation' => $affectation->idaffectation,
                'reference' => 'Facture ' . request('format'),
                'libelle' => "Reçu de paiement de facture",
                'type_mouvement' => "entree",
                'type_paiement' => request('type_paiement'),
                'montant' => request('montant'),
                'date' => request('date'),
            ];
            caisse::create($data_caisse);
        }
        return redirect("listeFacture")->with('success', 'Paiement enregistré avec succès !');
    }
}

