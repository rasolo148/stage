<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class service extends Model
{
    protected $table = 'service';
    protected $fillable = [
        'libelle',
        'tarif',
        'etat_suppression',
    ];

    public $timestamps = false;
    protected $primaryKey = "idservice";
    public $incrementing = false;
}

?>