<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagesModel extends Model
{
    use HasFactory;

    protected $table = 'pages';
    protected $primaryKey = 'id_pages';

    protected $fillable = ['title', 'slug', 'content'];
}
