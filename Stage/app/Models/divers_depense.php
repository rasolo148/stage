<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class divers_depense extends Model
{
    protected $table = 'divers_depense';
    protected $fillable = [
        'libelle',
        'montant',
        'idcategorie_depense',
        'idemploye',
        'date',
        'etat_suppression',
    ];

    public $timestamps = false;
    protected $primaryKey = "iddivers_depense";
    public $incrementing = false;
}

?>