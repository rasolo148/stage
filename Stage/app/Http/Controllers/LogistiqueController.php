<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\logistique;
use Illuminate\Support\Facades\DB;
use App\Models\type_logistique;

class LogistiqueController extends Controller
{
    public function form()
    {
       return view('crud/logistique/Form');
    }

    public function listeLogistique()
     {
        $bloc = 5;
        $page = request()->query('page', 1); // Valeur par défaut : 1
        $perPage = request()->query('perPage', $bloc); // Valeur par défaut : 10
        $currentPage = 1;

        $liste = DB::table("logistique")->orderBy("idlogistique", "asc")->paginate($perPage, ['*'], 'page', $page);

        $lastPage = $liste->lastPage(); 

        $listeNumeroPage = range(1, $lastPage);
       
        return view('crud/logistique/Liste',[
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

       
        $liste = DB::table("logistique")->orderBy("idlogistique", "asc")->paginate($perPage, ['*'], 'page', $page);

        
        $lastPage = $liste->lastPage(); 

        $listeNumeroPage = range(1, $lastPage);
       
        return view('crud/logistique/Liste',[
            'liste' => $liste,
            'currentPage' => request('numero'),
            'lastPage' => $lastPage,
            'listeNumeroPage' => $listeNumeroPage,
        ]);
     }

     public function ajouter(Request $request)
     {
         $data = $request->all();
         logistique::create($data);
         return redirect("listeLogistique")->with('success', 'Produit ajoutée avec succès !');
     }


     public function versmodifier()
     {
    $valeur =  collect(\DB::select('select * from logistique where idlogistique=? ', [request('id')]))->first();
        return view("crud/logistique/modifier",[
            'valeur' => $valeur,
        ]);
     }

     public function supprimer()
     {
       $id = logistique::find(request('id'));
       $id->delete();
       return redirect("listeLogistique")->with('suppression', 'Suppression avec succès !');
     }

     public function modifier(Request $request)
     {
        $data = $request->all();
        $item = logistique::find(request('idlogistique'));
        $item->update($data);
        return redirect("listeLogistique")->with('modification', 'Modification avec succès !');
     }

     public function recherche(Request $request)
     {
        $keyword = $request->input('motcle'); // récupérer le mot clé de la requête
        
        $results = DB::table('logistique')
        ->where(function($query) use ($keyword) {
            $query->where('logistique.libelle', 'LIKE', '%'.$keyword.'%')
                  ->orWhere('logistique.type_logistique', 'LIKE', '%'.$keyword.'%')
                  ->orWhere('logistique.marge_beneficiaire', 'LIKE', '%'.$keyword.'%');
        })
        ->get();
    
        $currentPage = 1;
        $lastPage = 3; 
        $listeNumeroPage = range(1, $lastPage);
       
        return view('crud/logistique/Liste',[
            'liste' => $results,
            'currentPage' => 1,
            'lastPage' => $lastPage,
            'listeNumeroPage' => $listeNumeroPage,
        ]);
    }
}
