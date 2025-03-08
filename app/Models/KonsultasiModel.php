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
        'organisasi'
    ];

    // Relasi ke tabel jurusan (opsional, jika ada)
    public function jurusan()
    {
        return $this->belongsTo(KriteriaModel::class, 'jurusan_asal', 'id_kriteria');
    }

    public function prestasi()
    {
        return $this->belongsTo(KriteriaModel::class, 'prestasi', 'id_kriteria');
    }

    public function organisasi()
    {
        return $this->belongsTo(KriteriaModel::class, 'organisasi', 'id_kriteria');
    }
}
