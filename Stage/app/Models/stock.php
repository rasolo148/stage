<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class stock extends Model
{
    protected $table = 'stock'; 
    protected $fillable = [
        'idlogistique',
        'quantiter',
        'type_mouvement',
        'observation',
    ];

    public $timestamps = false;
    protected $primaryKey = "idstock";
    public $incrementing = false;
}

?>