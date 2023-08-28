<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\voiture;
use App\Models\client;
use Illuminate\Support\Facades\DB;

class VoitureController extends Controller
{

    public function form()
    {
        $listeClient = client::all(); 
        return view('voiture/form', [
            'listeClient' => $listeClient,
        ]);
    }

    public function listeVoiture()
    {
       $bloc = 5;
       $page = request()->query('page',1); // Valeur par défaut : 1
       $perPage = request()->query('perPage',$bloc); // Valeur par défaut : 10
       $currentPage = 1;

       $liste = DB::table("v_voiture")->orderBy("v_voiture.idvoiture", "asc")->paginate($perPage, ['*'], 'page', $page);

       $lastPage = $liste->lastPage(); 

       $listeNumeroPage = range(1, $lastPage);
      
       return view('voiture/Liste',[
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

       $liste = DB::table("v_voiture")->orderBy("v_voiture.idvoiture", "asc")->paginate($perPage, ['*'], 'page', $page);
     
       $lastPage = $liste->lastPage(); 

       $listeNumeroPage = range(1, $lastPage);
      
       return view('voiture/Liste', [
           'liste' => $liste,
           'currentPage' => request('numero'),
           'lastPage' => $lastPage,
           'listeNumeroPage' => $listeNumeroPage,
       ]);
   }

    public function recherche(Request $request)
    {
       $keyword = $request->input('motcle'); // récupérer le mot clé de la requête
       
       $results = DB::table('v_voiture')->where(function($query) use ($keyword) {
           $query->where('v_voiture.nom', 'LIKE', '%'.$keyword.'%')->orWhere('v_voiture.contact', 'LIKE', '%'.$keyword.'%')->orWhere('v_voiture.adresse', 'LIKE', '%'.$keyword.'%')->orWhere('v_voiture.pseudo', 'LIKE', '%'.$keyword.'%')->orWhere('v_voiture.immatriculation', 'LIKE', '%'.$keyword.'%')->orWhere('v_voiture.marque', 'LIKE', '%'.$keyword.'%')->orWhere('v_voiture.modele', 'LIKE', '%'.$keyword.'%');
       })
       ->get();
   
       $currentPage = 1;
       $lastPage = 3; 
       $listeNumeroPage = range(1, $lastPage);
      
       return view('voiture/Liste',[
           'liste' => $results,
           'currentPage' => 1,
           'lastPage' => $lastPage,
           'listeNumeroPage' => $listeNumeroPage,
       ]);
   }

    public function ajouter(Request $request)
    {
        $data = $request->all();
        voiture::create($data);
        return redirect("listeVoiture")->with('success', 'Voiture ajoutée avec succès !');
    }
}
