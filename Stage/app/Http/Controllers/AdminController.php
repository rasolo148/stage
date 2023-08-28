<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\admin;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin/Admin_index');
    }


    //login admin
    public function log_admin(Request $request)
    {
        $login = admin::loggin(request('mail'), request('password'));
    
        if ($login == 0) {
            return redirect()->back()->with('error', 'Utilisateur ou mot de passe incorrect !');
        } 
        else 
        {
            return view('admin/Acceuill_admin');
        }
    }
    
    public function logout()
    {
        session()->flush();
        return redirect('/')->with('deconnecter', 'Vous êtes bien déconnecté !');
    }
}
