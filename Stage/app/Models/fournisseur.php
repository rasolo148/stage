<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class fournisseur extends Model
{
    protected $table = 'fournisseur';
    protected $fillable = [
        'nomfournisseur',
        'lieu',
    ];

    public $timestamps = false;
    protected $primaryKey = "idfournisseur";
    public $incrementing = false;
}

?>