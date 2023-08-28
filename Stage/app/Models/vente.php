<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vente extends Model
{
    protected $table = 'vente'; 
    protected $fillable = [
        'idclient',
        'idlogistique',
        'idfournisseur',
        'prix_unitaire',
        'quantite',
        'type_paiement',
        'date',
        'etat_paiement',
        'datemouvement',
    ];

    public $timestamps = false;
    protected $primaryKey = "idvente";
    public $incrementing = false;
}

?>