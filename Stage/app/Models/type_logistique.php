<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class type_logistique extends Model
{
    protected $table = 'type_logistique';
    protected $fillable = [
        'type',
    ];

    public $timestamps = false;
    protected $primaryKey = "idtype_logistique";
    public $incrementing = false;
}

?>