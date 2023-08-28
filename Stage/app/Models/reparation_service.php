<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class reparation_service extends Model
{
    protected $table = 'reparation_service';
    protected $fillable = [
        'iddemande',
        'idservice',
        'etat_suppression',
    ];
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = "idreparation_service";
}
?>