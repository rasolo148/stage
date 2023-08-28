<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class reparation_logistique extends Model
{
    protected $table = 'reparation_logistique';
    protected $fillable = [
        'iddemande',
        'idlogistique',
        'idfournisseur',
        'prix_unitaire',
        'quantite',
        'etat_paiement',
    ];
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = "idreparation_logistique";
}
?>