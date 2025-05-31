<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NormalisasiModel extends Model
{
    use HasFactory;

    protected $table = 'normalisasi';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_kasus_lama',
        'kd_kasus_lama',
        'nilai_rata_rata_rapor',
        'jurusan_asal',
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
        'id_prodi',
    ];

    // Relasi ke KasusLama 
    public function kasusLama()
    {
        return $this->belongsTo(KasusLamaModel::class, 'kd_kasus_lama', 'kd_kasus_lama');
    }
    public function prodi()
    {
        return $this->belongsTo(ProdiModel::class, 'id_prodi', 'id_prodi');
    }
}

