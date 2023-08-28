<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\achat;

class StockController extends Controller
{
    public function listeStock()
     {
        $bloc = 5;
        $page = request()->query('page',1); // Valeur par défaut : 1
        $perPage = request()->query('perPage',$bloc); // Valeur par défaut : 10
       
        $currentPage = 1;
       
        $liste = DB::table('v_stock_final_detail')->orderBy('v_stock_final_detail.idlogistique', 'asc')->paginate($perPage, ['*'], 'page', $page);
        
        $lastPage = $liste->lastPage(); 

        $listeNumeroPage = range(1, $lastPage);
       
        return view('stock/Liste',[
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
        $liste = DB::table('v_stock_final_detail')->orderBy('v_stock_final_detail.idlogistique', 'asc')->paginate($perPage, ['*'], 'page', $page);
        
        $lastPage = $liste->lastPage(); 

        $listeNumeroPage = range(1, $lastPage);
       
        return view('stock/Liste',[
            'liste' => $liste,
            'currentPage' => request('numero'),
            'lastPage' => $lastPage,
            'listeNumeroPage' => $listeNumeroPage,
        ]);
     }

     public function recherche(Request $request)
     {
         $keyword = $request->input('motcle'); // récupérer le mot clé de la requête
         
         $results = DB::table('v_stock_final_detail')
         ->where(function($query) use ($keyword) {
             $query->where('v_stock_final_detail.libelle', 'LIKE', '%'.$keyword.'%');
         })
         ->get();
     
             $currentPage = 1;
     
             $lastPage = 3; 
     
             $listeNumeroPage = range(1, $lastPage);
            
             return view('stock/Liste',[
                 'liste' => $results,
                 'currentPage' => 1,
                 'lastPage' => $lastPage,
                 'listeNumeroPage' => $listeNumeroPage,
             ]);
     }

     public function versmodifier()
     {
         return view('stock/modifier',[
             'libelle' => request('libelle'),
             'idlogistique' => request('idlogistique'),
             'idfournisseur' => request('idfournisseur'),
             'prix_unitaire' => request('prix_unitaire'),
         ]);
     }
     
     public function modifier()
     {
        achat::where('idlogistique', request('idlogistique'))
        ->where('idfournisseur', request('idfournisseur'))
        ->update([
            'prix_unitaire' => request('prix_unitaire'),
        ]);
        return redirect('listeStock')->with('success', 'Le prix unitaire a été modifié avec succès !');
     }
}
