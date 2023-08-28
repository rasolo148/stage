<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\demande_reparation;
use Illuminate\Support\Facades\DB;

class Mouvement_voitureController extends Controller
{

    public function listeMouvement_voiture()
    {
       $bloc = 5;
       $page = request()->query('page',1); // Valeur par défaut : 1
       $perPage = request()->query('perPage',$bloc); // Valeur par défaut : 10
       $currentPage = 1;
      
       $liste = DB::table('v_voiture')
       ->join('demande_reparation', 'v_voiture.idvoiture', '=', 'demande_reparation.idvoiture')
       ->orderBy('v_voiture.idvoiture', 'asc')
       ->paginate($perPage, ['*'], 'page', $page);

       
       $lastPage = $liste->lastPage(); 

       $listeNumeroPage = range(1, $lastPage);
      
       return view('mouvement_voiture/Liste',[
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

       $liste = DB::table('v_voiture')
       ->join('demande_reparation', 'v_voiture.idvoiture', '=', 'demande_reparation.idvoiture')
       ->orderBy('v_voiture.idvoiture', 'asc')
       ->paginate($perPage, ['*'], 'page', $page);

       $lastPage = $liste->lastPage(); 

       $listeNumeroPage = range(1, $lastPage);
      
       return view('mouvement_voiture/Liste', [
           'liste' => $liste,
           'currentPage' => request('numero'),
           'lastPage' => $lastPage,
           'listeNumeroPage' => $listeNumeroPage,
       ]);
   }

    public function recherche(Request $request)
    {

        $query = DB::table('v_voiture')
        ->join('demande_reparation', 'v_voiture.idvoiture', '=', 'demande_reparation.idvoiture');

        if (null !== $request->input('date_entree')) {
            $query->whereRaw("DATE(demande_reparation.date_entree) = ?", [$request->input('date_entree')]);
        }

        if (null !== $request->input('date_sortie')) {
            $query->whereRaw("DATE(demande_reparation.date_sortie) = ?", [$request->input('date_sortie')]);
        }        

        if (null !== $request->input('motcle')) 
        {
            $query->where('v_voiture.nom', 'like', '%' . $request->input('motcle') . '%')->orWhere('v_voiture.immatriculation', 'like', '%' . $request->input('motcle') . '%')->orWhere('v_voiture.marque', 'like', '%' . $request->input('motcle') . '%')->orWhere('v_voiture.modele', 'like', '%' . $request->input('motcle') . '%');
        }

        $results = $query->get();
        $lastPage = 3;
        $listeNumeroPage = range(1, $lastPage);
        return view('mouvement_voiture/Liste', [
            'liste' => $results,
            'currentPage' => 1,
            'lastPage' => $lastPage,
            'listeNumeroPage' => $listeNumeroPage,
        ]);
    }

    public function ajouter(Request $request)
    {
        $id = demande_reparation::find(request('iddemande'));
        $id->update([
            'nombre_mecaniciens' => request('nombre_mecaniciens'),
            'idnumero_place' => request('idnumero_place'),
            'datedebut' => request('datedebut'),
            'datefin' => request('datefin'),
            'date_entree' => request('date_entree'),
            'date_sortie' => request('date_sortie'),
        ]);
    
         if(request("type") == 'normal')
         {
            return redirect("listeParc")->with('success', '');
         }
         else {
            return redirect("versrdv")->with('success', '');
         }
    }

    public function sortir(Request $request)
    {
        $id = demande_reparation::find(request('iddemande'));
        $id->update([
            'date_sortie' => request('date_sortie'),
            'etat_sortie' => '1',
        ]);
        return redirect("listeParc")->with('success', '');
    }
}
