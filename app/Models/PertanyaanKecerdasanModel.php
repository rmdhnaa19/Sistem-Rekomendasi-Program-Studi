<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PertanyaanKecerdasanModel extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan_kecerdasan';
    protected $primaryKey = 'id_pertanyaan_kecerdasan';

    protected $fillable = ['pertanyaan', 'id_kecerdasan_majemuk', 'created_at', 'updated_at'];

    public function kecerdasan_majemuk():BelongsTo{
        return $this->belongsTo(KecerdasanMajemukModel::class, 'id_kecerdasan_majemuk');
}
}
