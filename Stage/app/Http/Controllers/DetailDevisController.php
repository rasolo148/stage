<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\demande_reparation;
use App\Models\reparation_employe;
use App\Models\reparation_service;
use App\Models\reparation_logistique;
use App\Models\reparation_depense;
use App\Models\PrixService;
use App\Models\facture;
use App\Models\logistique;

class DetailDevisController extends Controller
{
    public function suppDevisService()
    {
        $id = reparation_service::find(request('id'));
        $id->delete();
        return redirect()->back()->with('', 'La main d\'œuvre a été retirée du devis avec succès !');
    }

    public function suppDevisLogistique()
    {
        $id = reparation_logistique::find(request('id'));
        $id->delete();
        return redirect()->back()->with('', 'Le matériel logistique a été retiré du devis avec succès !');
    }


    public function modifierDevisService(Request $request)
    {
        $data = $request->all();
        $item = reparation_service::find(request('idreparation_service'));
        $item->update($data);
        return redirect('/formdevis/' . $data[''])->with('modification', 'La main d\'œuvre a été modifié avec succès !');
    }

    public function versmodifDevisService()
    {
        $valeur =  collect(\DB::select('select * from reparation_service where idreparation_service=?', [request('id')]))->first();

        return view("reparation/modifierService",[
            'valeur' => $valeur,
        ]);

    }

    public function modifierDevisLogistique(Request $request)
    {
        $data = $request->all();
        $item = reparation_logistique::find(request('idreparation_logistique'));
        $item->update($data);
        return redirect('/formdevis/' . $data['iddemande'])->with('', 'Le devis logistique a été modifié avec succès !');
    }

    public function versmodifDevisLogistique()
    {
        $valeur =  collect(\DB::select('select * from reparation_logistique where idreparation_logistique=?', [request('id')]))->first();

        return view("reparation/modifierLogistique",[
            'valeur' => $valeur,
        ]);

    }

}
