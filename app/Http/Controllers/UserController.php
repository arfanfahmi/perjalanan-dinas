<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role=='admin') {
            $users = DB::table('users')->orderBy('nama_pegawai')->paginate(25);
            
            return view('user/list-user', ["users"=>$users]);
        } else {
            return redirect('dashboard');
        }
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role=='admin') {
            return view('user/add', [
                'roles'=>['admin','pegawai','sdm']
            ]);
        } else {
            return redirect('dashboard');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->role=='admin') {
            $validated = $request->validate([
                'username' => 'required|unique:users|max:20|min:5|alpha_num',
                'nama_pegawai' => ['required','min:3'],
                'email' => 'email:dns',
                'role' =>'required',
                'nrp'=>'required|min:5'
            ]);

            $validated['password']=bcrypt('12345');
            
            $newUser = User::create($validated);
            return redirect('/user');
        } else {
            return redirect('dashboard');
        }
    }

  

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //return view('user/edit');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->role=='admin') {
            $user = DB::table('users')->where('username',$id)->first();
            return view('user/edit', [
                'roles'=>['admin','pegawai','sdm'],
                'user'=>$user
            ]);
        } else {
            return redirect('dashboard');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Auth::user()->role=='admin') {
            $validated = $request->validate([
                'nama_pegawai' => ['required','min:3'],
                'email' => 'email:dns',
                'role' =>'required',
                'nrp'=>'required|min:5'
            ]);

            $newUser = DB::table('users')->where('username',$id)->update($validated);
            return redirect('/user');
        } else {
            return redirect('dashboard');
        }
    }

    public function updatePassword(Request $request, $id)
    {
        $validated = $request->validate([
            'pass_lama' => 'required',
            'pass_baru' => 'required',
            'konfirm_pass' =>'required'
        ]);

        $user = DB::table('users')->where('username',$id)->get()->first();
        
        if (password_verify($validated['pass_lama'],$user->password) and ($validated['pass_baru']==$validated['konfirm_pass'])) {
            $newUser = DB::table('users')->where('username',$id)->update([
                "password" => $validated['pass_baru']
            ]);
            return redirect('/dashboard')->with('success-delete', 'Data telah dihapus!');;
        } else{
            return redirect('/dashboard')->with('success-delete', 'Data telah dihapus!');;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->role=='admin') {
            DB::table('users')->where('username',$id)->delete();
            return redirect('/user')->with('success-delete', 'Data telah dihapus!');
        } else {
            return redirect('dashboard');
        }
    }
}
