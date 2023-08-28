<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\achat;
use App\Models\logistique;
use Illuminate\Support\Facades\DB;
use App\Models\fournisseur;
use App\Models\FormatLetter;

class AchatController extends Controller
{
    public function form()
    {
       $listeLogistique = logistique::all();
       $listeFournisseur = fournisseur::all(); 
       return view('achat/Form',[
            'listeLogistique' => $listeLogistique,
            'listeFournisseur' => $listeFournisseur,
       ]);
    }

    public function listeAchat()
    {
        $bloc = 5;
        $page = request()->query('page', 1); // Valeur par défaut : 1
        $perPage = request()->query('perPage', $bloc); // Valeur par défaut : 10
        $currentPage = 1;

        $liste = DB::table("v_achat")->orderBy("datemouvement", "desc")->paginate($perPage, ['*'], 'page', $page);

        $lastPage = $liste->lastPage(); 

        $listeNumeroPage = range(1, $lastPage);
       
        return view('achat/Liste',[
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

        $liste = DB::table("v_achat")->orderBy("datemouvement", "desc")->paginate($perPage, ['*'], 'page', $page);

        $lastPage = $liste->lastPage(); 

        $listeNumeroPage = range(1, $lastPage);
       
        return view('achat/Liste',[
            'liste' => $liste,
            'currentPage' => request('numero'),
            'lastPage' => $lastPage,
            'listeNumeroPage' => $listeNumeroPage,
        ]);
    }

    public function ajouter(Request $request)
    {
        $data = $request->all();
        achat::create($data);
        return redirect("listeAchat")->with('success', 'Achat ajouté avec succès !');
    }

    public function versmodifier()
    {
        $valeur =  collect(\DB::select('select * from v_depenses where idachat=? ', [request('id')]))->first();
        return view("achat/modifier",[
            'valeur' => $valeur,
        ]);
    }

    public function supprimer()
    {
        $id = achat::find(request('id'));
        $id->delete();
        return redirect("listeAchat")->with('suppression', 'Suppression effectuée avec succès !');
    }

    public function modifier(Request $request)
    {
        $data = $request->all();
        $item = achat::find(request('idachat'));
        $item->update($data);
        return redirect("listeAchat")->with('modification', 'Modification effectuée avec succès !');
    }

    public function recherche(Request $request)
    {
        $keyword = $request->input('motcle'); // récupérer le mot clé de la requête
        
        $results = DB::table('v_achat')
        ->where(function($query) use ($keyword) {
            $query->where('v_achat.libelle', 'LIKE', '%'.$keyword.'%')
                  ->orWhere('v_achat.nomfournisseur', 'LIKE', '%'.$keyword.'%')
                  ->orWhere('v_achat.type_logistique', 'LIKE', '%'.$keyword.'%');
        })
        ->get();

        $currentPage = 1;
        $lastPage = 3; 
        $listeNumeroPage = range(1, $lastPage);
       
        return view('achat/Liste',[
            'liste' => $results,
            'currentPage' => 1,
            'lastPage' => $lastPage,
            'listeNumeroPage' => $listeNumeroPage,
        ]);
    }

    public function ajouterfournisseur(Request $request)
    {
         $data = $request->all();
         fournisseur::create($data);
         return redirect()->back()->with('success', 'Fournisseur ajouté avec succès !');
    }
}
