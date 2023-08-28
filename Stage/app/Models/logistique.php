<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class logistique extends Model
{
    protected $table = 'logistique';
    protected $fillable = [
        'libelle',
        'type_logistique',
        'marge_beneficiaire',
    ];

    public $timestamps = false;
    protected $primaryKey = "idlogistique";
    public $incrementing = false;
}

?>