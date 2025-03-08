<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class UserModel extends Model implements Authenticatable
{
    use HasFactory, AuthenticatableTrait;

    protected $table = 'user';
    protected $primaryKey = 'id_user';

    protected $fillable = ['nama', 'username', 'password', 'nip', 'jenis_kelamin', 
    'tanggal_lahir', 'no_hp', 'alamat', 'foto', 'created_at', 'updated_at'];
}
