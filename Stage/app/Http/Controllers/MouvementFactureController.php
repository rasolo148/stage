<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MouvementFactureController extends Controller
{

    public function mouvementfacture()
    {
        $liste = DB::table('v_facture')->join('paiementfacture','v_facture.idfacture','=','paiementfacture.idfacture')->select('v_facture.*','paiementfacture.type_paiement','paiementfacture.montant','paiementfacture.date as datepaiement', DB::raw('format_facture_id(v_facture.idfacture) as formatted_idfacture'))->orderBy("paiementfacture.datemouvement","desc")->get();
        return view('facture/Mouvement',[
            'liste' => $liste,
        ]);
    }

    public function recherche(Request $request)
    {
    $query = DB::table('v_facture')->join('paiementfacture','v_facture.idfacture','=','paiementfacture.idfacture')->select('v_facture.*','paiementfacture.montant','paiementfacture.date as datepaiement', DB::raw('format_facture_id(v_facture.idfacture) as formatted_idfacture'));

    
    if (null !== $request->input('date')) {
        $query->where('paiementfacture.date', '=', $request->input('date'));
    }
    
    $results = $query->get();
    $lastPage = 3;
    $listeNumeroPage = range(1, $lastPage);
    return view('facture/Mouvement', [
        'liste' => $results,
        'currentPage' => 1,
        'lastPage' => $lastPage,
        'listeNumeroPage' => $listeNumeroPage,
    ]);
    
    }
    

    
}
