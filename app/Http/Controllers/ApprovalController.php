<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use app\Http\Resources\DetailPerdinResource;

class ApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role=='sdm') {
            $perdins = DB::select('
                SELECT perdins.id, perdins.username, perdins.tgl_berangkat,perdins.tgl_kembali,perdins.keterangan,
                        a.nama_kota as kota_asal,a.latitude as lat_asal, a.longitude as lon_asal,
                        b.nama_kota as kota_tujuan,b.latitude as lat_tujuan, b.longitude as lon_tujuan,
                        users.nama_pegawai,users.nrp,
                        approvals.status,approvals.tgl_approval
                FROM perdins
                join kotas a on perdins.id_kota_asal = a.id
                join kotas b on perdins.id_kota_tujuan = b.id
                join users on users.username = perdins.username
                join approvals on approvals.id_perdin = perdins.id
                where approvals.status=:status
                order by perdins.id desc
                ',
                ['status'=>'diajukan']
            );
            return view('approval/list-approval', [
                'perdins'=>$perdins,
                'kotas'=>DB::table('kotas')->orderBy('nama_kota')->get()
            ]);
        } else {
            return redirect('dashboard');
        }
    }

    public function history()
    {
        if(Auth::user()->role=='sdm') {
            $perdins = DB::select('
                SELECT perdins.id, perdins.username, perdins.tgl_berangkat,perdins.tgl_kembali,perdins.keterangan,
                        a.nama_kota as kota_asal,a.latitude as lat_asal, a.longitude as lon_asal,
                        b.nama_kota as kota_tujuan,b.latitude as lat_tujuan, b.longitude as lon_tujuan,
                        users.nama_pegawai,users.nrp,
                        approvals.status,approvals.tgl_approval
                FROM perdins
                join kotas a on perdins.id_kota_asal = a.id
                join kotas b on perdins.id_kota_tujuan = b.id
                join users on users.username = perdins.username
                join approvals on approvals.id_perdin = perdins.id
                where approvals.status<>?
                order by perdins.id desc
                ',
                ['diajukan']
            );
            return view('approval/list-history-approval', [
                'perdins'=>$perdins,
                'kotas'=>DB::table('kotas')->orderBy('nama_kota')->get()
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
        if(Auth::user()->role=='sdm') {
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->role=='sdm') {
            $user = DB::table('users')->where('username',$id)->first();
            return view('user/edit', [
                'roles'=>['sdm','pegawai','sdm'],
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
        if(Auth::user()->role=='sdm') {
            DB::table('approvals')->where('id',$id)->update(
                ['status'=>$request->status]
            );
            return redirect('/approval')->with("success","Pengajuan perjalanan dinas telah ".$request->status);
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
        if(Auth::user()->role=='sdm') {
            DB::table('users')->where('username',$id)->delete();
            return redirect('/user')->with('success-delete', 'Data telah dihapus!');
        } else {
            return redirect('dashboard');
        }
    }
}
