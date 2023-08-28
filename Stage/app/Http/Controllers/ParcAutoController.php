<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\FormatDate;
use App\Models\demande_reparation;
use App\Models\numero_place;

class ParcAutoController extends Controller
{
    public function listeParc()
    {
        $bloc = 5;
        $page = request()->query('page',1); // Valeur par défaut : 1
        $perPage = request()->query('perPage',$bloc); // Valeur par défaut : 10
        $currentPage = 1;

        $liste = DB::table("v_parc")->paginate($perPage, ['*'], 'page', $page);
       
       
        $count = DB::table("v_parc")->whereRaw("v_parc.etat = 'Non libre' COLLATE utf8mb4_general_ci")->count();
        
        $lastPage = $liste->lastPage(); 

        $listeNumeroPage = range(1, $lastPage);

        return view('parc/Liste',[
            'liste' => $liste,
            'count' => $count,
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

       $liste = DB::table("v_parc")->paginate($perPage, ['*'], 'page', $page);
       
     
       $lastPage = $liste->lastPage(); 


       $listeNumeroPage = range(1, $lastPage);
       
       $count = DB::table("v_parc")->whereRaw("v_parc.etat = 'Non libre' COLLATE utf8mb4_general_ci")->count();
        
       return view('parc/Liste', [
           'liste' => $liste,
           'count' => $count,
           'currentPage' => request('numero'),
           'lastPage' => $lastPage,
           'listeNumeroPage' => $listeNumeroPage,
       ]);
   }

  
    public function recherche(Request $request)
    {
        $query = DB::table('v_parc');
        if (null !== $request->input('numero')) 
        {
            $query->where('v_parc.idnumero_place', '=',$request->input('numero'));
        }

        if (null !== $request->input('date_entree')) {
            $query->whereRaw("DATE(v_parc.date_entree) = ?", [$request->input('date_entree')]);
        }
   
        if (null !== $request->input('etat')) 
        {
            $etat = $request->input('etat');
            $query->whereRaw('v_parc.etat COLLATE utf8mb4_general_ci = ?', [$etat]);
        }
          
        if (null !== $request->input('motcle')) 
        {
            $query->where('v_parc.nom', 'like', '%' . $request->input('motcle') . '%')->orWhere('v_parc.immatriculation', 'like', '%' . $request->input('motcle') . '%')->orWhere('v_parc.marque', 'like', '%' . $request->input('motcle') . '%');
        }

        $itemsPerPage = 15; // Nombre d'éléments par page
        $results = $query->paginate($itemsPerPage);
        
        $count = DB::table("v_parc")->whereRaw("v_parc.etat = 'Non libre' COLLATE utf8mb4_general_ci")->count();
      
        $currentPage = 1;

        $lastPage = 1; 

        $listeNumeroPage = range(1, $lastPage);

        return view('parc/Liste',[
            'liste' => $results,
            'count' => $count,
            'currentPage' => 1,
            'lastPage' => $lastPage,
            'listeNumeroPage' => $listeNumeroPage,
        ]);
    }
      

    public function calendrier()
    {
        $currentMonth = date('m');
        $currentYear = date('Y'); // Année en cours
        
        $firstDayOfMonth = strtotime("$currentYear-$currentMonth-01");
        $daysOfWeek = array("Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche");
        $headers = [];
        
        $daysInMonth = date('t', $firstDayOfMonth); // Nombre de jours dans le mois
        

        $repairData = demande_reparation::whereMonth('datedebut', $currentMonth)
        ->whereYear('datedebut', $currentYear)
        ->get();

        $numeroPlaces = numero_place::all();

        for ($i = 0; $i < 31; $i++) {
            $currentDay = date('d', strtotime("+$i day", $firstDayOfMonth));
            $currentDayOfWeek = $daysOfWeek[date('N', strtotime("+$i day", $firstDayOfMonth)) - 1];
            $headers[] = "$currentDay";
        }
        return view('parc/Calendrier',[
            'repairData' => $repairData,
            'numeroPlaces' => $numeroPlaces,
            'headers' => $headers,
            'mois' => FormatDate::formatMonth($currentMonth),
            'annee' => $currentYear,
            'daysInMonth' => $daysInMonth,
        ]);

    }

    public function recherchecalendrier()
    {
        $currentMonth = request('mois');
        $currentYear = date('Y'); // Année en cours
        
        $firstDayOfMonth = strtotime("$currentYear-$currentMonth-01");
        $daysOfWeek = array("Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche");
        $headers = [];
        
        $daysInMonth = date('t', $firstDayOfMonth); // Nombre de jours dans le mois
        

        $repairData = demande_reparation::whereMonth('date_entree', $currentMonth)
        ->whereYear('date_entree', $currentYear)
        ->get();

        $numeroPlaces = numero_place::all();

        for ($i = 0; $i < 31; $i++) {
            $currentDay = date('d', strtotime("+$i day", $firstDayOfMonth));
            $currentDayOfWeek = $daysOfWeek[date('N', strtotime("+$i day", $firstDayOfMonth)) - 1];
            $headers[] = "$currentDay";
        }
    
        return view('parc/Calendrier',[
            'repairData' => $repairData,
            'numeroPlaces' => $numeroPlaces,
            'headers' => $headers,
            'mois' => FormatDate::formatMonth($currentMonth),
            'annee' => $currentYear,
            'daysInMonth' => $daysInMonth,
        ]);

    }

}
