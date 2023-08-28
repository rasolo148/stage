<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\vente;
use Illuminate\Support\Facades\DB;
use App\Models\client;

class VenteController extends Controller
{
    public function form()
    {
        $listeClient = client::all();
        $listeLogistique = DB::select("select l.libelle , l.type_logistique , v1.* , f.nomfournisseur from logistique l join v_stock_final v1 using(idlogistique) join fournisseur f using(idfournisseur)");
        return view('vente/Form', [
            'listeClient' => $listeClient,
            'listeLogistique' => $listeLogistique,
        ]);
    }

    public function listeVente()
    {
        $bloc = 5;
        $page = request()->query('page', 1); // Valeur par défaut : 1
        $perPage = request()->query('perPage', $bloc); // Valeur par défaut : 10
        $currentPage = 1;

        $liste = DB::table("v_vente")->orderBy("datemouvement", "desc")->paginate($perPage, ['*'], 'page', $page);

        $lastPage = $liste->lastPage();

        $listeNumeroPage = range(1, $lastPage);

        return view('vente/Liste', [
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


        $liste = DB::table("v_vente")->orderBy("datemouvement", "desc")->paginate($perPage, ['*'], 'page', $page);

        $lastPage = $liste->lastPage();

        $listeNumeroPage = range(1, $lastPage);

        return view('vente/Liste', [
            'liste' => $liste,
            'currentPage' => request('numero'),
            'lastPage' => $lastPage,
            'listeNumeroPage' => $listeNumeroPage,
        ]);
    }

    public function ajouter(Request $request)
    {

        $idclient = $request->input('idclient');
        $idlogistiques = $request->input('idlogistique_value');
        $quantites = $request->input('quantite');
        $prix_unitaires = $request->input('prix_unitaire');
        $date = $request->input('date');
        $type_paiement = $request->input('type_paiement');

        // Parcourez les valeurs du tableau idlogistique_value
        foreach ($idlogistiques as $index => $idlogistique) {

            // Divisez la chaîne en un tableau de valeurs
            list($idlogistique, $idfournisseur, $prix) = explode(',', $idlogistique);

            // Récupérez la valeur de la quantité pour cet index
            $quantite = $quantites[$index];
            $prix_unitaire = $prix_unitaires[$index];

            $query = collect(DB::select("select v1.quantite_restante from logistique l join v_stock_final v1 using(idlogistique) join fournisseur f using(idfournisseur) where idlogistique=? and idfournisseur=?", [$idlogistique, $idfournisseur]))->first();

            // Vérifiez si la quantité est suffisante
            if ($quantite > $query->quantite_restante) {
                return redirect()->back()->with('error', 'Quantite insuffisante');
            } else {
                vente::create([
                    'idclient' => $idclient,
                    'idlogistique' => $idlogistique,
                    'idfournisseur' => $idfournisseur,
                    'prix_unitaire' => $prix_unitaire,
                    'quantite' => $quantite,
                    'type_paiement' => $type_paiement,
                    'date' => $date,
                ]);
            }
        }

        return redirect('listeVente')->with('success', 'Vente ajoutée avec succès !');
    }

    public function recherche(Request $request)
    {
        $keyword = $request->input('motcle'); // récupérer le mot clé de la requête

        $results = DB::table('v_vente')
            ->where(function ($query) use ($keyword) {
                $query->where('v_vente.nom', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('v_vente.libelle', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('v_vente.type_logistique', 'LIKE', '%' . $keyword . '%');
            })
            ->get();

        $currentPage = 1;
        $lastPage = 3;
        $listeNumeroPage = range(1, $lastPage);

        return view('vente/Liste', [
            'liste' => $results,
            'currentPage' => 1,
            'lastPage' => $lastPage,
            'listeNumeroPage' => $listeNumeroPage,
        ]);
    }
}
