<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\service;

use Illuminate\Support\Facades\DB;


class ServiceController extends Controller
{
    public function form()
    {
       return view('crud/service/Form');
    }

    public function listeService()
     {
        $bloc = 5;
        $page = request()->query('page',1); // Valeur par défaut : 1
        $perPage = request()->query('perPage',$bloc); // Valeur par défaut : 10
        $currentPage = 1;

        $liste = DB::table("service")->orderBy("idservice", "asc")->paginate($perPage, ['*'], 'page', $page);

        $lastPage = $liste->lastPage(); 

        $listeNumeroPage = range(1, $lastPage);
       
        return view('crud/service/Liste',[
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

        $liste = DB::table("service")->orderBy("idservice", "asc")->paginate($perPage, ['*'], 'page', $page);

        $lastPage = $liste->lastPage(); 

        $listeNumeroPage = range(1, $lastPage);
       
        return view('crud/service/Liste',[
            'liste' => $liste,
            'currentPage' => request('numero'),
            'lastPage' => $lastPage,
            'listeNumeroPage' => $listeNumeroPage,
        ]);
     }

     public function ajouter(Request $request)
     {
         $data = $request->all();
         service::create($data);
         return redirect("listeService")->with('success', 'Le service a été ajouté avec succès !');
     }


     public function versmodifier()
     {
        $valeur =  collect(\DB::select('SELECT m.* , s.libelle , s.tarif  FROM service m join service s using(idservice) WHERE m.idservice=?', [request('id')]))->first();
        return view("crud/service/modifier",[
            'valeur' => $valeur,
        ]);
     }

     public function supprimer()
     {
       $id = service::find(request('id'));
       $id->delete();
       return redirect("listeService")->with('suppression', 'Le service a été supprimé avec succès !');
     }

     public function modifier(Request $request)
     {
        $data = $request->all();
        $item = service::find(request('idservice'));
        $item->update($data);
        return redirect("listeService")->with('modification', 'Le service a été modifié avec succès !');
     }

     public function recherche(Request $request)
     {
        $keyword = $request->input('motcle'); // récupérer le mot clé de la requête
        
        $results = DB::table('service')
        ->where(function($query) use ($keyword) {
            $query->where('service.libelle', 'LIKE', '%'.$keyword.'%')
                  ->orWhere('service.tarif', 'LIKE', '%'.$keyword.'%');
        })
        ->get();
    
        $currentPage = 1;
        $lastPage = 3; 
        $listeNumeroPage = range(1, $lastPage);
       
        return view('crud/service/Liste',[
            'liste' => $results,
            'currentPage' => 1,
            'lastPage' => $lastPage,
            'listeNumeroPage' => $listeNumeroPage,
        ]);
    }
}
