<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\demande_reparation;
use App\Models\reparation_employe;
use App\Models\reparation_service;
use App\Models\reparation_logistique;
use App\Models\reparation_depense;

class DevisController extends Controller
{
   
   public function devis_service(Request $request)
   {
       $data = $request->all();
       reparation_service::create($data);
       return redirect()->back()->with('', '');
   }
   
   public function devis_logistique(Request $request)
   {
       // Contrôle des valeurs
       $donnee = array();
       $donnee = explode(',', request('idlogistique'));
       $data = [
           'iddemande' => request('iddemande'),
           'idlogistique' => $donnee[0],
           'idfournisseur' => $donnee[1],
           'prix_unitaire' => $donnee[2],
           'quantite' => request('quantite'),
       ];

           reparation_logistique::create($data);
           return redirect()->back()->with('', '');
   }

}
