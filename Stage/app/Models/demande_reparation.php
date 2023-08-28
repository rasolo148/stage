<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class demande_reparation extends Model
{
    protected $table = 'demande_reparation'; 
    protected $fillable = [
        'idvoiture',
        'description',
        'prix_final',
        'nombre_mecaniciens',
        'datedebut',
        'datefin',
        'date_entree',
        'date_sortie',
        'etat_reparation',
        'idnumero_place',
        'etat_sortie',
        'type_demande',
        'datemouvement',
    ];
    public $timestamps = false;
    protected $primaryKey = "iddemande";
    public $incrementing = false;

    public static function getDetail($iddemande)
    {
        try {
            return self::find($iddemande);
        } catch (\Exception $e) {
            return null;
        }
    }
    
}

?>