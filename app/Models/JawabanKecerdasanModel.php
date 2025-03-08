<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanKecerdasanModel extends Model
{
    use HasFactory;

    protected $table = 'jawaban_kecerdasan';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_konsultasi',
        'id_pertanyaan_kecerdasan',
        'id_kecerdasan',
        'poin'
    ];

    // Relasi ke tabel Konsultasi
    public function konsultasi()
    {
        return $this->belongsTo(KonsultasiModel::class, 'id_konsultasi', 'id_konsultasi');
    }

    // Relasi ke tabel Pertanyaan Kecerdasan
    public function pertanyaanKecerdasan()
    {
        return $this->belongsTo(PertanyaanKecerdasanModel::class, 'id_pertanyaan_kecerdasan', 'id_pertanyaan_kecerdasan');
    }

    // Relasi ke tabel Kecerdasan Majemuk
    public function kecerdasan()
    {
        return $this->belongsTo(KecerdasanMajemukModel::class, 'id_kecerdasan', 'id_kecerdasan');
    }
}
