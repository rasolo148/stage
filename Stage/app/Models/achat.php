<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class achat extends Model
{
    protected $table = 'achat'; 
    protected $fillable = [
        'idlogistique',
        'idfournisseur',
        'quantiter',
        'marque',
        'modele',
        'reference',
        'prix_unitaire',
        'type_paiement',
        'date',
        'etat_paiement',
        'datemouvement',
    ];

    public $timestamps = false;
    protected $primaryKey = "idachat";
    public $incrementing = false;
}

?>