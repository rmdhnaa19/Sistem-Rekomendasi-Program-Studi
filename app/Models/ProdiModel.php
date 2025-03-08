<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProdiModel extends Model
{
    use HasFactory;

    protected $table = 'prodi';
    protected $primaryKey = 'id_prodi';

    protected $fillable = ['nama_prodi', 'id_jurusan', 'akreditasi', 'jenjang', 'durasi_studi', 
    'tahun_berdiri', 'deskripsi', 'created_at', 'updated_at'];

    public function jurusan():BelongsTo{
        return $this->belongsTo(JurusanModel::class, 'id_jurusan', 'id_jurusan');
}
}
