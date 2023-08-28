<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\demande_reparation;
use App\Models\demande_rdv;
use App\Models\numero_place;

class DemandeRdvController extends Controller
{
    public function suggest()
    {
        // isRendezVousAvailable

        $iddemande = request('iddemande');  
        $result = demande_rdv::isRendezVousAvailable($iddemande);
        $nextClosestDates = $result['nextClosestDates'];

        foreach ($nextClosestDates as $dates) 
        {
            $dateDebutSuggeree = $dates['datedebut'];
            $dateFinSuggeree = $dates['datefin'];
        }

        $demande = demande_rdv::getDemande($iddemande);
       
        return view('client/suggestion', [
            'nextClosestDates' => $nextClosestDates,
            'demande' => $demande,
            'diffHours' => demande_rdv::diffHours($demande),
            'countWorks' =>  demande_rdv::countWorks($iddemande),
        ]);
    }

    public function reserve()
    {
        $iddemande = request('iddemande'); 
        $date = request('date');
        $datefin = request('datefin');

        $id = demande_reparation::find($iddemande); 

        $id->update([
            'date' => $date,
            'datefin' => $datefin,
            'etat_reparation' => '1'
        ]);
        
        return redirect("client")->with('success', 'Rendez-vous réservé avec succès !');
    }

    public function vers()
    {
        $listePlace = numero_place::all();
        
        $bloc = 5;
        $page = request()->query('page',1); // Valeur par défaut : 1
        $perPage = request()->query('perPage',$bloc); // Valeur par défaut : 10
        $currentPage = 1;
            
        $liste = DB::table("v_demande")->where('type_demande','rdv')->orderBy('v_demande.datemouvement', 'desc')->paginate($perPage, ['*'], 'page', $page);
        

        $lastPage = $liste->lastPage(); 

        $listeNumeroPage = range(1, $lastPage);

        return view('client/rdv',[
            'listePlace' => $listePlace,
            'listeDemande' => $liste,
            'currentPage' => $currentPage,
            'lastPage' => $lastPage,
            'listeNumeroPage' => $listeNumeroPage,
        ]);
    }

    public function ajout()
    {
        
        $data = [
            'idvoiture' => request('idvoiture'),
            'description' => request('description'),
            'datedebut' => request('datedebut'),
            'datefin'  => request('datefin'),
            'idnumero_place' => request('idnumero_place'),
            'type_demande' => 'rdv',
        ];
        demande_reparation::create($data);
        return redirect("versrdv")->with('success', 'Rendez-vous réservé avec succès !');
    }

    public function annuler()
    {
        $id = demande_reparation::find(request('iddemande'));
        $id->delete();
        return redirect("versrdv")->with('success', 'Rendez-vous annulé avec succès !');
    }

}
