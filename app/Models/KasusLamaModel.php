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
    

    public function normalisasi()
{
    return $this->hasOne(NormalisasiModel::class, 'id_kasus_lama');
}

    // Relasi ke Prodi (Pastikan bahwa `nama_prodi` menyimpan `id_prodi`, bukan nama)
    public function prodi()
    {
        return $this->belongsTo(ProdiModel::class, 'id_prodi', 'id_prodi');
    }

    public function prodi_by_name()
    {
        return $this->belongsTo(ProdiModel::class, 'nama_prodi', 'nama_prodi');
    }

    
public static function generateKodeKasus()
{
    // Ambil angka terbesar dari kd_kasus_lama (tanpa prefix 'KL')
    $maxCode = self::max(\DB::raw("CAST(SUBSTRING(kd_kasus_lama, 3) AS UNSIGNED)"));
    
    // Mulai dari 1 jika belum ada data
    $newNumber = $maxCode ? $maxCode + 1 : 1;
    
    return 'KL' . $newNumber;
}

protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        if (empty($model->kd_kasus_lama)) {
            \DB::beginTransaction();
            try {
                $kode = self::generateKodeKasus();

                // Jika ternyata sudah ada (race condition), naikkan lagi sampai unik
                while (self::where('kd_kasus_lama', $kode)->exists()) {
                    $numberOnly = (int) substr($kode, 2);
                    $kode = 'KL' . ($numberOnly + 1);
                }

                $model->kd_kasus_lama = $kode;

                \DB::commit();
            } catch (\Exception $e) {
                \DB::rollBack();
                throw $e;
            }
        }
    });
}
}