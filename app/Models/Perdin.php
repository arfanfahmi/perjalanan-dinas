<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perdin extends Model
{
    use HasFactory;

    protected $fillable=['nrp','id_kota_asal','id_kota_tujuan','tgl_berangkat','tgl_kembali','keterangan'];
}
