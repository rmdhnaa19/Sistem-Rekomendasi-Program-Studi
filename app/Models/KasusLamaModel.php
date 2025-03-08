<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasusLamaModel extends Model
{
    use HasFactory;

    protected $table = 'kasus_lama';
    public $incrementing = false; // Karena kode dibuat manual
    protected $primaryKey = 'kd_kasus_lama'; // Pastikan PK sesuai

    protected $fillable = [
        'kd_kasus_lama',
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
        'nama_prodi',
    ];

    // Relasi ke Kriteria (Jurusan Asal)
    public function jurusan()
    {
        return $this->belongsTo(KriteriaModel::class, 'jurusan_asal', 'id_kriteria');
    }

    // Relasi ke Kriteria (Prestasi)
    public function prestasi()
    {
        return $this->belongsTo(KriteriaModel::class, 'prestasi', 'id_kriteria');
    }

    // Relasi ke Kriteria (Organisasi)
    public function organisasi()
    {
        return $this->belongsTo(KriteriaModel::class, 'organisasi', 'id_kriteria');
    }

    // Relasi ke Prodi (Pastikan bahwa `nama_prodi` menyimpan `id_prodi`, bukan nama)
    public function prodi()
    {
        return $this->belongsTo(ProdiModel::class, 'nama_prodi', 'id_prodi');
    }

    /**
     * Generate kode otomatis untuk kd_kasus_lama
     */
    public static function generateKodeKasus()
    {
        $lastKode = self::orderBy('kd_kasus_lama', 'desc')->first();

        if ($lastKode && preg_match('/KL(\d+)/', $lastKode->kd_kasus_lama, $matches)) {
            $newNumber = (int) $matches[1] + 1;
        } else {
            $newNumber = 1;
        }

        return 'KL' . str_pad($newNumber, 2, '0', STR_PAD_LEFT);
    }

    /**
     * Atur kode otomatis sebelum insert jika tidak ada
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->kd_kasus_lama)) {
                $model->kd_kasus_lama = self::generateKodeKasus();
            }
        });
    }
}
