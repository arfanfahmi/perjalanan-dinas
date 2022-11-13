<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {        
        $role = Auth::user()->role;
        if ($role=='admin') {                       //role = admin
            return redirect('/dashboard/admin');
        } else if($role == 'sdm') {                 //role = sdm
            return redirect('/dashboard/sdm');
        } else {                                    //role = pegawai
            return redirect('/dashboard/pegawai');
        }
    }

    public function admin() {
        if (Auth::user()->role=='admin') {
            return app('App\Http\Controllers\UserController')->index();
        } else {
            return redirect('dashboard');
        }
    }

    public function sdm() {
        if (Auth::user()->role=='sdm') {
            return app('App\Http\Controllers\ApprovalController')->index();
        } else {
            return redirect('dashboard');
        }
    }

    public function pegawai() {
        if (Auth::user()->role=='pegawai') {
            return app('App\Http\Controllers\PerdinController')->index();
        } else {
            return redirect('dashboard');
        }
    }
}
