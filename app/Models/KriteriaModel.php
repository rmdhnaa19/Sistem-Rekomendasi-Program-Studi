<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaModel extends Model
{
    use HasFactory;

    protected $table = 'kriteria';
    protected $primaryKey = 'id_kriteria';

    protected $fillable = ['jenis_kriteria', 'nama_kriteria', 'created_at', 'updated_at'];
}