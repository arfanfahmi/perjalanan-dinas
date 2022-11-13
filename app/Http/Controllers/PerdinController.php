<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PerdinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role=='pegawai') {
            $username = Auth::user()->username;

            $perdins = DB::select('
                SELECT perdins.username, perdins.tgl_berangkat,perdins.tgl_kembali,perdins.keterangan,
                        a.nama_kota as kota_asal,a.latitude as lat_asal, a.longitude as lon_asal,
                        b.nama_kota as kota_tujuan,b.latitude as lat_tujuan, b.longitude as lon_tujuan,
                        users.nama_pegawai,users.nrp,
                        approvals.status,approvals.tgl_approval
                FROM perdins
                join kotas a on perdins.id_kota_asal = a.id
                join kotas b on perdins.id_kota_tujuan = b.id
                join users on users.username = perdins.username
                join approvals on approvals.id_perdin = perdins.id
                where perdins.username=:name
                order by approvals.status, perdins.id desc
                ',
                ['name'=> $username]
            );
            return view('perdin/list-perdin', [
                'perdins'=>$perdins,
                'kotas'=>DB::table('kotas')->orderBy('nama_kota')->get()
            ]);
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
        if(Auth::user()->role=='pegawai') {
            return view('perdin/add', [
                'kota'=>DB::table('kota')->orderBy('nama_kota')->get()
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
        if(Auth::user()->role=='pegawai') {
            
            DB::table('perdins')->insert([
                'username' =>$request->username,
                'id_kota_asal' =>$request->id_kota_asal,
                'id_kota_tujuan' => $request->id_kota_tujuan,
                'tgl_berangkat' => $request->tgl_berangkat,
                'tgl_kembali' => $request->tgl_kembali,
                'keterangan' => $request->keterangan
            ]);

            $id = DB::table('perdins')->where('username', $request->username)->orderByDesc('id')->first();
            
            DB::table('approvals')->insert([
                'id_perdin'=>$id->id,
                'status' =>'diajukan'
            ]);
            
            return redirect('/perdin');
        } else {
            return redirect('dashboard');
        }
    }

    
    public function cekPerdinby($id,$tgl_berangkat,$tgl_kembali) {
        if(Auth::user()->role=='pegawai') {
            $username = Auth::user()->username;

            $perdins = DB::select('
                SELECT perdins.*,approvals.status from perdins 
                    join approvals
                on 
                    perdins.id = approvals.id_perdin
                where 
                    username = ? 
                    and status <> ?
                    and ((? > tgl_berangkat and ? < tgl_kembali) or (? > tgl_berangkat and ? < tgl_kembali))
                ',
                [$id, 'ditolak', $tgl_berangkat, $tgl_berangkat, $tgl_kembali, $tgl_kembali]
            );
            return json_encode($perdins);
            return response()->json([
                'perdins' => $perdins
            ]);
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->role=='pegawai') {
            $user = DB::table('users')->where('username',$id)->first();
            return view('user/edit', [
                'roles'=>['pegawai','pegawai','pegawai'],
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
        if(Auth::user()->role=='pegawai') {
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->role=='pegawai') {
            DB::table('users')->where('username',$id)->delete();
            return redirect('/user')->with('success-delete', 'Data telah dihapus!');
        } else {
            return redirect('dashboard');
        }
    }
}
