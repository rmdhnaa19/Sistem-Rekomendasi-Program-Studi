<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KecerdasanMajemukModel extends Model
{
    use HasFactory;

    protected $table = 'kecerdasan_majemuk';
    protected $primaryKey = 'id_kecerdasan_majemuk';

    protected $fillable = ['nama_kecerdasan', 'deskripsi', 'created_at', 'updated_at'];
}
