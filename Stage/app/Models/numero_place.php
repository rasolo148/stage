<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class numero_place extends Model
{
    protected $table = 'numero_place';
    protected $fillable = [
        'numero_place',
    ];

    public $timestamps = false;
    protected $primaryKey = "idnumero_place";
    public $incrementing = false;
}

?>