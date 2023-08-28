<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use \Carbon\Carbon;

class PrixService extends Model
{
    // calcul devis Service 
    public static function devis_service($iddemande)
    {
        try {
            $detailService = collect(DB::select("select sum(s.tarif) as tarif_total from v_demande v1 join reparation_service v2 using(iddemande) join service s using(idservice) where v1.iddemande=?",[$iddemande]))->first();
            return $detailService->tarif_total;
        }
        catch (\Exception $e) {
            return 0;
        }           
    }

    //calcul devis Logistiques
    public static function devis_logistique($iddemande)
    {
        try {
            $detailLogistique = collect(DB::select("SELECT sum(v2.prix_unitaire * v2.quantite * (1 + l.marge_beneficiaire / 100)) AS prix_total
            FROM v_demande v1
            JOIN reparation_logistique v2 USING (iddemande)
            JOIN logistique l USING (idlogistique)
            WHERE v1.iddemande = ?    
        ",[$iddemande]))->first();
           return $detailLogistique->prix_total;
        }
        catch (\Exception $e) {
            return 0;
        }           
    }

    public static function devis_frais_diverses($iddemande)
    {
        $fraisDiagnostic = collect(DB::select("SELECT frais_diverses FROM demande_reparation where iddemande = ?   
    ",[$iddemande]))->first();
        return $fraisDiagnostic->frais_diverses;
    }

    public static function devis_prestation_externe($iddemande)
    {
        $fraisDiagnostic = collect(DB::select("SELECT prestation_externe FROM demande_reparation where iddemande = ?   
    ",[$iddemande]))->first();
        return $fraisDiagnostic->prestation_externe;
    }


    // prix final devis 
    public static function prix_final($iddemande)
    {
      $prix_final = self::devis_service($iddemande) + self::devis_logistique($iddemande) + self::devis_frais_diverses($iddemande) + self::devis_prestation_externe($iddemande);
      $tableau = array(
        "devis_service" => self::devis_service($iddemande),
        "devis_logistique" => self::devis_logistique($iddemande),
        "devis_frais_diverses" => self::devis_frais_diverses($iddemande),
        "devis_prestation_externe" => self::devis_prestation_externe($iddemande),
        "prix_final" => $prix_final
      );
    return $tableau;
    }

}
