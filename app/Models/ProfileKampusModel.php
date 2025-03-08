<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ProfileKampusModel extends Model
{
    use HasFactory;

    protected $table = 'profile_kampus';
    protected $primaryKey = 'id_profile_kampus';

    protected $fillable = ['logo', 'judul', 'deskripsi', 'youtube_link'];
}
