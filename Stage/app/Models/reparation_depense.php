<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class reparation_depense extends Model
{
    protected $table = 'reparation_depense';
    protected $fillable = [
        'iddemande',
        'libelle',
        'montant',
    ];
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = "idreparation_depense";
}
?>