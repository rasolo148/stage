<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class caisse extends Model
{
    protected $table = 'caisse'; 
    protected $fillable = [
        'type_mouvement',
        'idaffectation',
        'reference',
        'libelle',
        'type_paiement',
        'montant',
        'date',
        'datemouvement',
    ];

    public $timestamps = false;
    protected $primaryKey = "idcaisse";
    public $incrementing = false;

    public static function getMontantTotal($liste)
    {
        $total = 0;
        foreach ($liste as $rows) {
            $total += $rows->montant_total;
        }
        return $total;
    }

    public static function getTypePaiement($indice) {
        if ($indice == 1) 
        {
            return 'Espece';
        } 
        elseif ($indice == 2) 
        {
            return 'Mvola';
        } 
        elseif ($indice == 3) 
        {
            return 'Banque';
        } 
    }

    public static function loadCaisseView($indice, $liste, $currentPage, $lastPage, $listeNumeroPage, $listeAffectation) {
        $viewName = 'caisse/Liste';
    
        if ($indice == 2) {
            $viewName = 'caisse/Liste2';
        } elseif ($indice == 3) {
            $viewName = 'caisse/Liste3';
        }
    
        return view($viewName, [
            'liste' => $liste,
            'currentPage' => $currentPage,
            'lastPage' => $lastPage,
            'listeNumeroPage' => $listeNumeroPage,
            'listeAffectation' => $listeAffectation,
        ]);
    }
    
    public static function getlastSolde($typeMouvement,$dateActuelle)
    {
        $result = DB::table('v_caisse')
        ->selectRaw('solde')
        ->where('type_paiement', $typeMouvement)
        ->whereDate('date', '<', $dateActuelle)
        ->orderBy('datemouvement', 'desc')
        ->first();

        if ($result) {
            return $result->solde;
        } 
        else 
        {
        return 0; // ou une valeur par défaut appropriée
        }
    }

    public static function getLastSoldDay($typeMouvement, $dateActuelle) 
    {
        $result = DB::table('v_caisse')
            ->selectRaw('solde')
            ->where('type_paiement', $typeMouvement)
            ->whereDate('date', $dateActuelle)
            ->orderBy('datemouvement', 'desc')
            ->first();
        if ($result) {
            return $result->solde;
        } else {
            return self::getLastSolde($typeMouvement,$dateActuelle);
        }
    }

    public static function journal($typeMouvement,$dateActuelle)
    {
        return  DB::table('v_caisse')->whereDate('v_caisse.date',$dateActuelle)->where('v_caisse.type_paiement',$typeMouvement)->orderBy('v_caisse.datemouvement', 'desc')->get();
    }

    
}

?>