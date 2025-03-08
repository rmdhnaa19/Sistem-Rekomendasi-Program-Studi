<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubKriteriaModel extends Model
{

    use HasFactory;

    protected $table = 'sub_kriteria';
    protected $primaryKey = 'id_sub_kriteria';

    protected $fillable = ['nama_sub', 'nilai', 'id_kriteria', 'created_at', 'updated_at'];

    public function kriteria():BelongsTo{
        return $this->belongsTo(KriteriaModel::class, 'id_kriteria', 'id_kriteria');
}
}