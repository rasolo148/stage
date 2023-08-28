<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class reparation_employe extends Model
{
    protected $table = 'reparation_employe';
    protected $fillable = [
        'iddemande',
        'idemploye',
        'temps_estime',
        'etat_suppression',
    ];
    public $timestamps = false;
    public $incrementing = 'idreparation_employe';
    protected $primaryKey = "idreparation_employe";
}
?>