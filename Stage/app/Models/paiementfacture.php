<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class paiementfacture extends Model
{
    protected $table = 'paiementfacture';
    protected $fillable = [
        'idfacture',
        'montant',
        'type_paiement',
        'date',
        'datemouvement',
    ];

    public $timestamps = false;
    protected $primaryKey = "idpaiementfacture";
    public $incrementing = false;
}

?>