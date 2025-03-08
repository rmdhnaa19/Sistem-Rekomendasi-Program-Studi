<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurusanModel extends Model
{
    use HasFactory;

    protected $table = 'jurusan';
    protected $primaryKey = 'id_jurusan';

    protected $fillable = ['nama_jurusan', 'deskripsi', 'created_at', 'updated_at'];
}
