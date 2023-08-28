<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\caisse;
use App\Models\affectation;
use App\Models\Admin;
use Carbon\Carbon;
use App\Models\FormatDate;

class CaisseController extends Controller
{
    
    public function ajouter(Request $request)
    {
        $indice = request('indice');
        $type_mouvement = caisse::getTypePaiement($indice);
        $data = $request->all();
        $data = [
            'idaffectation' => request('idaffectation'),
            'reference' => request('reference'),
            'libelle' => request('libelle'),
            'type_mouvement' => request('type_mouvement'),
            'type_paiement' => $type_mouvement,
            'montant' => request('montant'),
            'date' => request('date'),
        ];
        caisse::create($data);
        return redirect("listeCaisse/{$indice}")->with('success', 'Mouvement caisse '. $type_mouvement .' effectué avec succès !');
    }


    public function listeCaisse()
    {
        $bloc = 5;
        $page = request()->query('page', 1); // Valeur par défaut : 1
        $perPage = request()->query('perPage', $bloc); // Valeur par défaut : 10
       
        $currentPage = 1;
        
        $indice = request('indice');
        $type_mouvement = caisse::getTypePaiement($indice);

        $liste = DB::table('v_caisse')->where('v_caisse.type_paiement',$type_mouvement)->orderBy('v_caisse.datemouvement', 'desc')->paginate($perPage, ['*'], 'page', $page);
        
        $lastPage = $liste->lastPage(); 

        $listeNumeroPage = range(1, $lastPage);

        $listeAffectation = DB::table('affectation')->join('categorie_depense', 'affectation.idcategorie_depense', '=', 'categorie_depense.idcategorie_depense')->get();
        
        return caisse::loadCaisseView($indice, $liste, $currentPage, $lastPage, $listeNumeroPage, $listeAffectation);
    }

    public function pagination(Request $request)
    {
        $bloc = 5;
        $page = request()->query('page', request('numero')); // Valeur par défaut : 1
        $perPage = request()->query('perPage', $bloc); // Valeur par défaut : 10
        $currentPage = request('numero');
       
        
        $indice = request('indice');
        $type_mouvement = caisse::getTypePaiement($indice);

        $liste = DB::table('v_caisse')->where('v_caisse.type_paiement',$type_mouvement)->orderBy('v_caisse.datemouvement', 'desc')->paginate($perPage, ['*'], 'page', $page);
        

        $lastPage = $liste->lastPage(); 
        $listeNumeroPage = range(1, $lastPage);
        $listeAffectation = DB::table('affectation')->join('categorie_depense', 'affectation.idcategorie_depense', '=', 'categorie_depense.idcategorie_depense')->get();
        return caisse::loadCaisseView($indice, $liste, $currentPage, $lastPage, $listeNumeroPage, $listeAffectation);
    }

    public function recherche(Request $request)
    {
      
        $indice = request('indice');
        $type_mouvement = caisse::getTypePaiement($indice);
        
        $query = "SELECT * FROM v_caisse";
        $bindings = array();
        
        if (null !== $request->input('indice')) {
            $query .= " WHERE v_caisse.type_paiement LIKE ?";
            $bindings[] = "%" . $type_mouvement . "%";
        }
        
        if (null !== $request->input('motcle')) {
            $query .= (count($bindings) > 0 ? " AND" : " WHERE") . " (reference LIKE ? OR libelle LIKE ? OR affectation LIKE ?)";
            $motcle = "%" . $request->input('motcle') . "%";
            $bindings[] = $motcle;
            $bindings[] = $motcle;
            $bindings[] = $motcle;
        }
        
        if (null !== $request->input('datedebut')) {
            $query .= (count($bindings) > 0 ? " AND" : " WHERE") . " date = ?";
            $bindings[] = $request->input('datedebut');
        }
        
        $results = \DB::select($query, $bindings);
        
        $lastPage = 5;
        $listeNumeroPage = range(1, $lastPage);
        $listeAffectation = DB::table('affectation')
            ->join('categorie_depense', 'affectation.idcategorie_depense', '=', 'categorie_depense.idcategorie_depense')
            ->get();
        
        return caisse::loadCaisseView($indice,$results,1, $lastPage, $listeNumeroPage, $listeAffectation);
        
    }

    public function versmodifier()
    {
        $valeur =  DB::table('v_caisse')->where("v_caisse.idcaisse", request('idcaisse'))->first();
        $login = Admin::logg(request('mdp'), "admin");
        if ($login == 0) {
            session(['numero' => $valeur->idcaisse]);
            return redirect()->back()->with('error', 'Mot de passe incorrect');
        } 
        else 
        {
            $listeAffectation = DB::table('affectation')->join('categorie_depense', 'affectation.idcategorie_depense', '=', 'categorie_depense.idcategorie_depense')->get();
            return view("caisse/modifier", [
                'valeur' => $valeur,
                'listeAffectation' => $listeAffectation,
            ]);
        }  
    }

    public function modifier(Request $request)
    {
        $data = $request->all();
        $item = caisse::find(request('idcaisse'));
        $item->update($data);
        return redirect("listeCaisse")->with('modification', 'Modification effectuée avec succès !');
    }

    public function journal()
    {
        $dateSysteme = Carbon::now();
        $dateActuelle = $dateSysteme->format('Y-m-d');
        return view('caisse/Journal',[
            'dateActuelle' => $dateActuelle
        ]);
    }
     
}
