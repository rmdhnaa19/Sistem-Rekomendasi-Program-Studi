<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonsultasiModel extends Model
{
    use HasFactory;
    
    protected $table = 'konsultasi';
    protected $primaryKey = 'id_konsultasi';
    public $timestamps = true;

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
        'similarity',
        'kd_kasus_lama',
    ];

    // Relasi ke tabel jurusan (opsional, jika ada)
    public function kasusLama()
    {
        return $this->belongsTo(KasusLamaModel::class, 'kd_kasus_lama', 'kd_kasus_lama');
    }

}
