<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if (!Auth::user())
            return view('login');
        else
            return redirect('dashboard');
    }

    public function authenticate(Request $request) {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials)) {
            
            $request->session()->regenerate();
            return redirect('dashboard');
        }
        
        return back()->with('error', 'Username atau password salah');
    }

    public function logout(Request $request) {
        Auth::logout(); 
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
