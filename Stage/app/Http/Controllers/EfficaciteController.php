<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class EfficaciteController extends Controller
{
    public function listeEfficacite()
     {
        $bloc = 5;
        $page = request()->query('page',1); // Valeur par défaut : 1
        $perPage = request()->query('perPage',$bloc); // Valeur par défaut : 10
       
        $currentPage = 1;

        $liste = DB::table('v_temps_moyen')->orderBy('v_temps_moyen.idvoiture', 'asc')->paginate($perPage, ['*'], 'page', $page);
        
        $lastPage = $liste->lastPage(); 

        $listeNumeroPage = range(1, $lastPage);
       
        return view('statistiques/efficacite/Liste',[
            'liste' => $liste,
            'currentPage' => $currentPage,
            'lastPage' => $lastPage,
            'listeNumeroPage' => $listeNumeroPage,
        ]);
     }

     public function pagination(Request $request)
     {
        $bloc = 5;
        $page = request()->query('page',request('numero')); // Valeur par défaut : 1
        $perPage = request()->query('perPage',$bloc); // Valeur par défaut : 10
        $currentPage = request('numero');
        $liste = DB::table('v_temps_moyen')->orderBy('v_temps_moyen.idvoiture', 'asc')->paginate($perPage, ['*'], 'page', $page);
        
        $lastPage = $liste->lastPage(); 

        $listeNumeroPage = range(1, $lastPage);
       
        return view('statistiques/efficacite/Liste',[
            'liste' => $liste,
            'currentPage' => request('numero'),
            'lastPage' => $lastPage,
            'listeNumeroPage' => $listeNumeroPage,
 
        ]);
     }

     public function recherche(Request $request)
     {
         $keyword = $request->input('motcle'); // récupérer le mot clé de la requête
         $results = DB::table('v_temps_moyen')
         ->where(function($query) use ($keyword) {
             $query->where('v_temps_moyen.nom', 'LIKE', '%'.$keyword.'%')->orWhere('v_temps_moyen.immatriculation', 'LIKE', '%'.$keyword.'%');
         })
         ->get();
     
             $currentPage = 1;
     
             $lastPage = 3; 
     
             $listeNumeroPage = range(1, $lastPage);
            
             return view('statistiques/efficacite/Liste',[
                 'liste' => $results,
                 'currentPage' => 1,
                 'lastPage' => $lastPage,
                 'listeNumeroPage' => $listeNumeroPage,
             ]);
     }
     
}
