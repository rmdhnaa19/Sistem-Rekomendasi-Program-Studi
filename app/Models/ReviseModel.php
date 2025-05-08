<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'kec_eksistensial',
        'id_prodi',
        'status',
    ];

    public $timestamps = true;

// Relasi ke Prodi (Pastikan bahwa `nama_prodi` menyimpan `id_prodi`, bukan nama)
public function prodi()
{
    return $this->belongsTo(ProdiModel::class, 'id_prodi', 'id_prodi');
}

public function jurusan()
{
    return $this->belongsTo(SubKriteriaModel::class, 'jurusan_asal', 'id_sub_kriteria');
}

public function prestasi()
{
    return $this->belongsTo(SubKriteriaModel::class, 'prestasi', 'id_sub_kriteria');
}

public function organisasi()
{
    return $this->belongsTo(SubKriteriaModel::class, 'organisasi', 'id_sub_kriteria');
}

}