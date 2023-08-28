<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Stat extends Model
{
     public static function Taux_utilisation()
     {
// Récupérer le nombre total de demandes de réparation
$totalDemandes = DB::table('demande_reparation')->count();

// Récupérer la répartition des demandes par service
$services = DB::table('reparation_service')
    ->join('service', 'reparation_service.idservice', '=', 'service.idservice')
    ->select('service.libelle', DB::raw('COUNT(reparation_service.idreparation_service) as nombre_demandes'))
    ->groupBy('service.libelle')
    ->get();

// Calculer le taux de répartition pour chaque service
$repartitionServices = [];
foreach ($services as $service) {
    $taux = ($service->nombre_demandes / $totalDemandes) * 100;
    $repartitionServices[$service->libelle] = round($taux, 2);
}

// Compléter avec 0% pour les services non utilisés
$allServices = DB::table('service')->pluck('libelle');
foreach ($allServices as $service) {
    if (!isset($repartitionServices[$service])) {
        $repartitionServices[$service] = 0.00;
    }
}

return $repartitionServices;

    }

    

}

?>