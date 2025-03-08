<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasusBaruModel extends Model
{
    use HasFactory;
    protected $table = 'kasus_baru';
    protected $primaryKey = 'id_kasus_baru';

    protected $fillable = [
        'nama',
        'jurusan_asal',
        'nilai_rata_rata_rapor',
        'prestasi',
        'organisasi',
        'kec_linguistik',
        'kec_musikal',
        'kec_logika_matematis',
        'kec_spasial',
        'kec_kinestetik',
        'kec_interpersonal',
        'kec_intrapersonal',
        'kec_naturalis',
        'kec_eksistensial',
        'frekuensi',
    ];
}
