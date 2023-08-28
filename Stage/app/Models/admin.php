<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
class admin extends Model
{
    protected $fillable = [
        'mail',
        'password',
        'fonction',
    ];

    public $timestamps = false;
    protected $primaryKey = "idadmin";
    public $incrementing = false;

      //login admin
      public static function loggin($mail, $mdp)
      {
          $login = collect(\DB::select('select count(*) as isa from admin where mail = ? and password = ?', [$mail, $mdp]))->first();
          return $login->isa;
      } 
  
      public static function is_admin($mail, $mdp)
      {
          $is_admin = collect(\DB::select('select role  from admin where mail = ? and password = ?', [$mail, $mdp]))->first();
          return $is_admin->role;
      }

    public static function logg($mdp, $role)
    {
        $login = collect(\DB::select('select count(*) as isa from admin where password = ? and role=?', [$mdp, $role]))->first();
        return $login->isa;
    }
}
