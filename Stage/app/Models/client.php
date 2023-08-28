<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class client extends Model
{
    protected $table = 'client'; 
    protected $fillable = [
        'nom',
        'contact',
        'adresse',
        'pseudo',
    ];

    public $timestamps = false;
    protected $primaryKey = "idclient";
    public $incrementing = false;
}

?>