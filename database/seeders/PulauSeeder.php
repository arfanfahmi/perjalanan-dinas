<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PulauSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pulaus = [
            
            ["nama_pulau"=>"Sumatera"],
            ["nama_pulau"=>"Jawa"],  
            ["nama_pulau"=>"Bali"], 
            ["nama_pulau"=>"Kalimantan"], 
            ["nama_pulau"=>"Sulawesi"], 
            ["nama_pulau"=>"Papua"],

            ["nama_pulau"=>"Nias"], 
            ["nama_pulau"=>"Kepulauan Batu"], 
            ["nama_pulau"=>"Kepulauan Mentawai"], 
            ["nama_pulau"=>"Kepulauan Meranti"], 
            ["nama_pulau"=>"Bangka"], 
            ["nama_pulau"=>"Belitung"], 
            ["nama_pulau"=>"Karimun Besar"], 
            ["nama_pulau"=>"Bintan"], 
            ["nama_pulau"=>"Natuna Besar"], 
            ["nama_pulau"=>"Lingga"], 
            ["nama_pulau"=>"Batam"], 
            ["nama_pulau"=>"Anambas"], 
            ["nama_pulau"=>"Kepulauan Seribu"],             
            ["nama_pulau"=>"Madura"], 
            
            ["nama_pulau"=>"Lombok"], 
            ["nama_pulau"=>"Sumbawa"], 
            ["nama_pulau"=>"Sumba"], 
            ["nama_pulau"=>"Timor"], 
            ["nama_pulau"=>"Alor"], 
            ["nama_pulau"=>"Lembata"], 
            ["nama_pulau"=>"Flores"], 
            ["nama_pulau"=>"Sawu"],             
            ["nama_pulau"=>"Pulau Laut"],             
            ["nama_pulau"=>"Sangihe"], 
            ["nama_pulau"=>"Talaud"], 
            ["nama_pulau"=>"Banggai"], 
            ["nama_pulau"=>"Selayar"], 
            ["nama_pulau"=>"Buton"], 
            ["nama_pulau"=>"Muna"], 
            ["nama_pulau"=>"Wakatobi"], 
            ["nama_pulau"=>"Kai Tanimbar"], 
            ["nama_pulau"=>"Kai Kecil"], 
            ["nama_pulau"=>"Maluku"], 
            ["nama_pulau"=>"Buru"], 
            ["nama_pulau"=>"Kepulauan Aru"], 
            ["nama_pulau"=>"Seram"], 
            ["nama_pulau"=>"Ambon"], 
            ["nama_pulau"=>"Wetar"],
            ["nama_pulau"=>"Halmahera"], 
            ["nama_pulau"=>"Kepulauan Sula"], 
            ["nama_pulau"=>"Ternate"], 
            ["nama_pulau"=>"Tidore"], 
            ["nama_pulau"=>"Morotai"],
            ["id"=>1000, "nama_pulau"=>"(Luar Negeri)"]
        ];
        
        DB::table('pulaus')->insert($pulaus);
    }
}
