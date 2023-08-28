<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\client;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{

    public function listeClient()
     {
        $bloc = 5;
        $page = request()->query('page',1); // Valeur par défaut : 1
        $perPage = request()->query('perPage',$bloc); // Valeur par défaut : 10
        $currentPage = 1;

        $liste = DB::table("client")->orderBy("idclient", "asc")->paginate($perPage, ['*'], 'page', $page);

        $lastPage = $liste->lastPage(); 

        $listeNumeroPage = range(1, $lastPage);
       
        return view('client/Liste',[
            'liste' => $liste,
            'currentPage' => $currentPage,
            'lastPage' => $lastPage,
            'listeNumeroPage' => $listeNumeroPage,
        ]);
     }

     public function ajouter(Request $request)
     {
         $data = $request->all();
         client::create($data);
         return redirect("listeClient")->with('success', 'Le client a été ajouté avec succès !');
     }

     public function recherche(Request $request)
     {
        $keyword = $request->input('motcle'); // récupérer le mot clé de la requête
        
        $results = DB::table('client')
        ->where(function($query) use ($keyword) {
            $query->where('client.nom', 'LIKE', '%'.$keyword.'%')->orWhere('client.contact', 'LIKE', '%'.$keyword.'%')->orWhere('client.adresse', 'LIKE', '%'.$keyword.'%')->orWhere('client.pseudo', 'LIKE', '%'.$keyword.'%');
        })
        ->get();
    
        $currentPage = 1;
        $lastPage = 3; 
        $listeNumeroPage = range(1, $lastPage);
       
        return view('client/Liste',[
            'liste' => $results,
            'currentPage' => 1,
            'lastPage' => $lastPage,
            'listeNumeroPage' => $listeNumeroPage,
        ]);
    }

    public function index()
    {
        $listeVoiture = DB::select("select v.* , c.nom , c.pseudo from voiture v join client c using(idclient)");
        $bloc = 5;
        $page = request()->query('page', 1); // Valeur par défaut : 1
        $perPage = request()->query('perPage', $bloc); // Valeur par défaut : 10
        $currentPage = 1;
        $libre = 'libre'; 

        $listeDemande = DB::table("v_demande")->orderBy("v_demande.datemouvement", "desc")->paginate($perPage, ['*'], 'page', $page);
        
        $listePlace = DB::table("v_parc")->whereRaw("v_parc.etat = 'libre' COLLATE utf8mb4_general_ci")->get();


        $lastPage = $listeDemande->lastPage(); 

        $listeNumeroPage = range(1, $lastPage);
        return view('client/index', [
            'listePlace' => $listePlace,
            'listeVoiture' => $listeVoiture,
            'listeDemande' => $listeDemande,
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

       
        $liste = DB::table("client")->orderBy("idclient", "asc")->paginate($perPage, ['*'], 'page', $page);
        $lastPage = $liste->lastPage(); 

        $listeNumeroPage = range(1, $lastPage);
       
        return view('client/Liste', [
            'liste' => $liste,
            'currentPage' => request('numero'),
            'lastPage' => $lastPage,
            'listeNumeroPage' => $listeNumeroPage,
        ]);
    }

    public function recherchedemande(Request $request)
    {
        $keyword = $request->input('motcle'); // récupérer le mot clé de la requête
        $listeVoiture = DB::select("select v.* , c.nom from voiture v join client c using(idclient)");
        $results = DB::table('v_demande')
            ->where(function($query) use ($keyword) {
                $query->where('v_demande.nom', 'LIKE', '%'.$keyword.'%')
                      ->orWhere('v_demande.description', 'LIKE', '%'.$keyword.'%');
            })
            ->get();       
            $lastPage = 3;
            $listeNumeroPage = range(1, $lastPage);
            $listePlace = DB::table("v_parc")->whereRaw("v_parc.etat = 'libre' COLLATE utf8mb4_general_ci")->get();

        return view('client/Liste', [
            'listePlace' => $listePlace,
            'listeVoiture' => $listeVoiture,
            'listeDemande' => $results,
            'currentPage' => 1,
            'lastPage' => $lastPage,
            'listeNumeroPage' => $listeNumeroPage,
        ]);
    }


}
