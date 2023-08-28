<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class affectation extends Model
{
    protected $table = 'affectation'; 
    protected $fillable = [
        'libelle',
        'idcategorie_depense',
        'type_mouvement',
    ];

    public $timestamps = false;
    protected $primaryKey = "idaffectation";
    public $incrementing = false;
}

?>