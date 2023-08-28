<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\affectation;
use App\Models\categorie_depense;
use App\Models\employe;
use Illuminate\Support\Facades\DB;

class AffectationController extends Controller
{
    public function form()
    {
       $listeDepense = categorie_depense::all();
       $listeEmploye = employe::all(); 
       return view('crud/affectation/Form',[
            'listeDepense' => $listeDepense,
            'listeEmploye' => $listeEmploye,
       ]);
    }

    public function listeAffectation()
     {
        $bloc = 5;
        $page = request()->query('page',1); // Valeur par défaut : 1
        $perPage = request()->query('perPage',$bloc); // Valeur par défaut : 10
        $currentPage = 1;

        $liste = DB::table('affectation')
        ->join('categorie_depense', 'affectation.idcategorie_depense', '=', 'categorie_depense.idcategorie_depense')
        ->orderBy('affectation.idaffectation', 'asc')
        ->paginate($perPage, ['*'], 'page', $page);
    
        $lastPage = $liste->lastPage(); 

        $listeNumeroPage = range(1, $lastPage);
       
        return view('crud/affectation/Liste',[
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

        $liste = DB::table('affectation')
        ->join('categorie_depense', 'affectation.idcategorie_depense', '=', 'categorie_depense.idcategorie_depense')
        ->orderBy('affectation.idaffectation', 'asc')
        ->paginate($perPage, ['*'], 'page', $page);

        $lastPage = $liste->lastPage(); 

        $listeNumeroPage = range(1, $lastPage);
       
        return view('crud/affectation/Liste',[
            'liste' => $liste,
            'currentPage' => request('numero'),
            'lastPage' => $lastPage,
            'listeNumeroPage' => $listeNumeroPage,
        ]);
     }

     public function ajouter(Request $request)
     {
         $data = $request->all();
         affectation::create($data);
         return redirect("listeAffectation")->with('success', 'Affectation ajoutée avec succès !');
     }


     public function versmodifier()
     {
    $valeur =  collect(\DB::select('select * from affectation a join categorie_depense c using(idcategorie_depense) where a.idaffectation=? ', [request('id')]))->first();
    $listeDepense = categorie_depense::all();
        return view("crud/affectation/modifier",[
            'valeur' => $valeur,
            'listeDepense' => $listeDepense,
        ]);
     }

     public function supprimer()
     {
       $id = affectation::find(request('id'));
       $id->delete();
       return redirect("listeAffectation")->with('suppression', 'Suppression effectuée avec succès !');
     }

     public function modifier(Request $request)
     {
        $data = $request->all();
        $item = affectation::find(request('idaffectation'));
        $item->update($data);
        return redirect("listeAffectation")->with('modification', 'Modification effectuée avec succès !');
     }

     public function recherche(Request $request)
{
    $keyword = $request->input('motcle'); // récupérer le mot clé de la requête
    
    $results = DB::table('affectation')
    ->join('categorie_depense', 'affectation.idcategorie_depense', '=', 'categorie_depense.idcategorie_depense')
->where(function($query) use ($keyword) {
        $query->where('categorie_depense.categorie', 'LIKE', '%'.$keyword.'%')
              ->orWhere('affectation.libelle', 'LIKE', '%'.$keyword.'%');
    })
    ->get();

        $currentPage = 1;

        $lastPage = 3; 

        $listeNumeroPage = range(1, $lastPage);
       
        return view('crud/affectation/Liste',[
            'liste' => $results,
            'currentPage' => 1,
            'lastPage' => $lastPage,
            'listeNumeroPage' => $listeNumeroPage,
        ]);
}

}
