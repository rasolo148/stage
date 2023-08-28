<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class employe extends Model
{
    protected $table = 'employe';
    protected $fillable = [
        'nom',
        'prenom',
        'fonction',
        'salaire_de_base',
        'etat_suppression',
    ];

    public $timestamps = false;
    protected $primaryKey = "idemploye";
    public $incrementing = false;
}

?>