<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\DetailPerdinResource;


class DetailPerdinController extends Controller
{
    
    public function show($id)
    {
        
        $perdins = DB::select('
            SELECT perdins.id as id_perdin, perdins.username, perdins.tgl_berangkat,perdins.tgl_kembali,perdins.keterangan,
                    a.id as id_kota_asal, a.nama_kota as kota_asal,a.latitude as lat_asal, a.longitude as lon_asal,
                    b.id as id_kota_tujuan, b.nama_kota as kota_tujuan,b.latitude as lat_tujuan, b.longitude as lon_tujuan,b.ln as ln,
                    users.nama_pegawai,users.nrp,
                    approvals.status,approvals.tgl_approval
            FROM perdins
            join kotas a on perdins.id_kota_asal = a.id
            join kotas b on perdins.id_kota_tujuan = b.id
            join users on users.username = perdins.username
            join approvals on approvals.id_perdin = perdins.id
            where perdins.id = ?
            order by perdins.id desc
            ',
            [$id]
        );
        
        $perdins = $perdins[0];

        $jumlah_hari = (strtotime($perdins->tgl_kembali)-strtotime($perdins->tgl_berangkat))/(3600*24)+1;
        $jarak = $this->getDistanceBetweenPoints($perdins->lat_asal, $perdins->lon_asal, 
            $perdins->lat_tujuan, $perdins->lon_tujuan);
        
        $ongkos = $this->getOngkosHarian($jarak,$perdins->id_kota_asal, $perdins->id_kota_tujuan);

        $arrPerdins = array(
            'id_perdin'=>$perdins->id_perdin,
            'id_kota_asal' =>$perdins->id_kota_asal,
            'id_kota_tujuan'=>$perdins->id_kota_tujuan,
            'tgl_berangkat'=>$perdins->tgl_berangkat,
            'tgl_kembali' =>$perdins->tgl_kembali,
            'keterangan' =>$perdins->keterangan,
            'jumlah_hari'=>$jumlah_hari,
            'jarak' =>$jarak,
            'luar_negeri'=>$perdins->ln,
            'status'=>$perdins->status,
            'ongkos_per_hari' =>$ongkos['tarif'],
            'kategori_perdin' =>$ongkos['kategori'],
            'nama_pegawai'=>$perdins->nama_pegawai
        );
        
        //return json_encode($arrPerdins);
        return new DetailPerdinResource(true, "List Detail Tarif", $arrPerdins);
    }

    private function getDistanceBetweenPoints($lat1, $lon1, $lat2, $lon2) {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $kilometers = $miles * 1.609344;
        return $kilometers; 
    }

    private function getOngkosHarian($jarak, $id_kota_asal, $id_kota_tujuan) {
        $tabel_tarif = array(
            "luar_negeri"=>50,
            "kurang_60_km"=>0,
            "lebih_60_km_satu_provinsi"=>200000,
            "lebih_60_km_beda_provinsi_satu_pulau"=>250000,
            "lebih_60_km_beda_provinsi_beda_pulau"=>300000
        );

        $ongkos = array("kategori","tarif");

        $kota_asal = DB::table('kotas')->where("id",$id_kota_asal)->get()->first();
        $kota_tujuan = DB::table('kotas')->where("id",$id_kota_tujuan)->get()->first();

        //luar negeri
        if ($kota_tujuan->ln == "Y") {
            $ongkos["kategori"] = "Luar Negeri";
            $ongkos["tarif"] = $tabel_tarif["luar_negeri"];
            return $ongkos;
        }

        // jarak < 60km
        if ($jarak <= 60) {
            $ongkos["kategori"] = "Jarak 0-60 km";
            $ongkos["tarif"] = $tabel_tarif["kurang_60_km"];
            return $ongkos;
        } 
        
        // Jarak > 60km tapi 1 provinsi
        if ($kota_asal->id_provinsi == $kota_tujuan->id_provinsi) {
            $ongkos["kategori"] = "Jarak > 60 km dalam 1 provinsi";
            $ongkos["tarif"] = $tabel_tarif["lebih_60_km_satu_provinsi"];
            return $ongkos;
        } 
        
        // Jarak > 60 km, beda provinsi
        if ($kota_asal->id_provinsi != $kota_tujuan->id_provinsi) {
            
            //Jarak > 60km, beda provinsi, 1 pulau
            if ($kota_asal->id_pulau == $kota_tujuan->id_pulau) {
                $ongkos["kategori"] = "Jarak > 60 km, beda provinsi namun 1 pulau";
                $ongkos["tarif"] = $tabel_tarif["lebih_60_km_beda_provinsi_satu_pulau"];
                return $ongkos;
            } 
            
            //Jarak > 60km, beda provinsi, beda pulau
            else {
                $ongkos["kategori"] = "Jarak > 60 km, beda provinsi dan pulau";
                $ongkos["tarif"] = $tabel_tarif["lebih_60_km_beda_provinsi_beda_pulau"];
                return $ongkos;
            }
        }
        
    }

    //Source : https://gist.github.com/LucaRosaldi/5676464
    // private function getDistanceBetweenPoints($lat1, $lon1, $lat2, $lon2) {
    //     $theta = $lon1 - $lon2;
    //     $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
    //     $miles = acos($miles);
    //     $miles = rad2deg($miles);
    //     $miles = $miles * 60 * 1.1515;
    //     $feet = $miles * 5280;
    //     $yards = $feet / 3;
    //     $kilometers = $miles * 1.609344;
    //     $meters = $kilometers * 1000;
    //     return compact('miles','feet','yards','kilometers','meters'); 
    // }
}
