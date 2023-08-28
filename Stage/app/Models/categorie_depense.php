<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class categorie_depense extends Model
{
    protected $table = 'categorie_depense';
    protected $fillable = [
        'categorie',
    ];

    public $timestamps = false;
    protected $primaryKey = "idcategorie_depense";
    public $incrementing = false;
}

?>