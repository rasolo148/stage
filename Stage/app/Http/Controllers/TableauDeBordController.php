<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\FormatDate;

class TableauDeBordController extends Controller
{


    public function liste()
    {
        $mois = date('m');
        $annee = date('Y');
    
        $listeFraisDeSIEGE = DB::select('CALL sp_tableau_bord(?, ?, ?)', [$mois, $annee, 1]);
        $listeFraisDAtelier = DB::select('CALL sp_tableau_bord(?, ?, ?)', [$mois, $annee, 2]);
        $listeRecettes = DB::select('CALL sp_tableau_bord(?, ?, ?)', [$mois, $annee, 3]);

        $moisFR = FormatDate::formatMonth($mois);


        return view('statistiques/chiffre/TableauDeBord',[
            'listeFraisDeSiege' => $listeFraisDeSIEGE,
            'listeFraisDAtelier' => $listeFraisDAtelier,
            'listeRecettes' => $listeRecettes,
            'moisFR' => $moisFR,
            'annee' => $annee,
        ]);
    }



     public function recherche(Request $request) {
    
    $mois = $request->input('mois');
    $annee = $request->input('annee');

    $listeFraisDeSIEGE = DB::select('CALL sp_tableau_bord(?, ?, ?)', [$mois, $annee, 1]);
    $listeFraisDAtelier = DB::select('CALL sp_tableau_bord(?, ?, ?)', [$mois, $annee, 2]);
    $listeRecettes = DB::select('CALL sp_tableau_bord(?, ?, ?)', [$mois, $annee, 3]);

    $moisFR = FormatDate::formatMonth($mois);

    return view('statistiques/chiffre/TableauDeBord',[
        'listeFraisDeSiege' => $listeFraisDeSIEGE,
        'listeFraisDAtelier' => $listeFraisDAtelier,
        'listeRecettes' => $listeRecettes,
        'moisFR' => $moisFR,
        'annee' => $annee,
    ]);

    }
     
}
