<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviseModel extends Model
{
    use HasFactory;

    protected $table = 'revise';
    protected $primaryKey = 'id_revise';
    protected $fillable = [
        'kd_revise',
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
        'prodi',
        'similarity_score',
        'status',
    ];

    public $timestamps = true;
}