<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinsiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $provinsis = [
            ["id"=>"1", "nama_provinsi"=>"Aceh"],
            ["id"=>"2", "nama_provinsi"=>"Sumatera Utara"],
            ["id"=>"3", "nama_provinsi"=>"Sumatera Barat"],
            ["id"=>"4", "nama_provinsi"=>"Riau"],
            ["id"=>"5", "nama_provinsi"=>"Jambi"],
            ["id"=>"6", "nama_provinsi"=>"Sumatera Selatan"],
            ["id"=>"7", "nama_provinsi"=>"Bengkulu"],
            ["id"=>"8", "nama_provinsi"=>"Lampung"],
            ["id"=>"9", "nama_provinsi"=>"Kepulauan Bangka Belitung"],
            ["id"=>"10", "nama_provinsi"=>"Kepulauan Riau"],
            ["id"=>"11", "nama_provinsi"=>"DKI Jakarta"],
            ["id"=>"12", "nama_provinsi"=>"Jawa Barat"],
            ["id"=>"13", "nama_provinsi"=>"Jawa Tengah"],
            ["id"=>"14", "nama_provinsi"=>"DI Yogyakarta"],
            ["id"=>"15", "nama_provinsi"=>"Jawa Timur"],
            ["id"=>"16", "nama_provinsi"=>"Banten"],
            ["id"=>"17", "nama_provinsi"=>"Bali"],
            ["id"=>"18", "nama_provinsi"=>"Nusa Tenggara Barat"],
            ["id"=>"19", "nama_provinsi"=>"Nusa Tenggara Timur"],
            ["id"=>"20", "nama_provinsi"=>"Kalimatan Barat"],
            ["id"=>"21", "nama_provinsi"=>"Kalimantan Tengah"],
            ["id"=>"22", "nama_provinsi"=>"Kalimantan Selatan"],
            ["id"=>"23", "nama_provinsi"=>"Kalimantan Timur"],
            ["id"=>"24", "nama_provinsi"=>"Sulawesi Utara"],
            ["id"=>"25", "nama_provinsi"=>"Sulawesi Tengah"],
            ["id"=>"26", "nama_provinsi"=>"Sulawesi Selatan"],
            ["id"=>"27", "nama_provinsi"=>"Sulawesi Tenggara"],
            ["id"=>"28", "nama_provinsi"=>"Gorontalo"],
            ["id"=>"29", "nama_provinsi"=>"Sulawesi Barat"],
            ["id"=>"30", "nama_provinsi"=>"Maluku"],
            ["id"=>"31", "nama_provinsi"=>"Maluku Utara"],
            ["id"=>"32", "nama_provinsi"=>"Papua Barat"],
            ["id"=>"33", "nama_provinsi"=>"Papua"],
            ["id"=>"1000", "nama_provinsi"=>"(Luar Negeri)"]
        ];
        DB::table('provinsis')->insert($provinsis);
    }
}
