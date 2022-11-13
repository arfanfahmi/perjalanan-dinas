<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kota;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if(Auth::user()->role=='sdm') {  
        $kotas = DB::table('kotas')
            ->join('provinsis', 'kotas.id_provinsi','=','provinsis.id')
            ->join('pulaus','pulaus.id','=','kotas.id_pulau')
            ->select('kotas.*','provinsis.nama_provinsi','pulaus.nama_pulau')
            ->orderByDesc('kotas.id')->paginate(25);
        
        return view('kota/list-kota', ["kotas"=>$kotas]);
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
        if(Auth::user()->role=='sdm') {    
            return view('kota/add', [
                'provinsis'=>DB::table('provinsis')->get(),
                'pulaus'=>DB::table('pulaus')->get()
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
        $id_pulau="";
        $id_provinsi="";
        if ($request->ln=='Y') {
            $id_pulau = 1000;
            $id_provinsi = 1000;
        } else {
            $id_pulau = $request->id_pulau;
            $id_provinsi = $request->id_provinsi;
        }
        
        if(Auth::user()->role=='sdm') {
            $newKota = Kota::create([
                'nama_kota' =>$request->nama_kota,
                'id_provinsi' =>$id_provinsi,
                'id_pulau' => $id_pulau,
                'ln'=>$request->ln,
                'latitude'  =>$request->latitude,
                'longitude' =>$request->longitude
            ]);
            return redirect('/kota');
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
        //return view('kota/edit');
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
            $kota = DB::table('kotas')->where('id',$id)->first();
            return view('kota/edit', [
                'provinsis'=>DB::table('provinsis')->get(),
                'pulaus'=>DB::table('pulaus')->get(),
                'kota'=>$kota
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
            $id_pulau="";
            $id_provinsi="";
            if ($request->ln=='Y') {
                $id_pulau = 1000;
                $id_provinsi = 1000;
            } else {
                $id_pulau = $request->id_pulau;
                $id_provinsi = $request->id_provinsi;
            }

            $newKota = DB::table('kotas')->where('id',$id)->update
            ([
                'nama_kota' =>$request->nama_kota,
                'id_provinsi' =>$id_provinsi,
                'id_pulau' => $id_pulau,
                'ln'=>$request->ln,
                'latitude'  =>$request->latitude,
                'longitude' =>$request->longitude
            ]);
            return redirect('/kota');
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
            DB::table('kotas')->where('id',$id)->delete();
            return redirect('/kota')->with('flashKey', 'flashValue');
        } else {
            return redirect('dashboard');
        }     
    }
}
