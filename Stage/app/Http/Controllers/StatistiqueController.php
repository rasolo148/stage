<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Stat;

class StatistiqueController extends Controller
{
    public function listeStatistique()
     {

        $liste = DB::select('CALL p_statistiques(YEAR(NOW()), NULL)');
               
        return view('statistiques/chiffre/Liste',[
            'liste' => $liste,
        ]);
     }

     public function recherche(Request $request) {

        $mois = $request->input('mois');
        $annee = $request->input('annee');
        
        if (null == $annee) {
            $annee = date('Y');
        }
        $results = DB::select('CALL p_statistiques(?, ?)', [$annee,$mois]);

        $lastPage = 5;
        $listeNumeroPage = range(1, $lastPage);
        return view('statistiques/chiffre/Liste', [
            'liste' => $results,
            'currentPage' => 1,
            'lastPage' => $lastPage,
            'listeNumeroPage' => $listeNumeroPage,
        ]);
        
        }

        public function taux()
        {
            $taux = Stat::Taux_utilisation();
            return view('statistiques/taux/Liste',[
                'taux' => $taux,
            ]);
        }
     
}
