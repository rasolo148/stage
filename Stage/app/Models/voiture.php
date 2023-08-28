<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class voiture extends Model
{
    protected $table = 'voiture'; 
    protected $fillable = [
        'idclient',
        'immatriculation',
        'marque',
        'modele',
        'borne',
        'energie',
    ];

    public $timestamps = false;
    protected $primaryKey = "idvoiture";
    public $incrementing = false;
}

?>