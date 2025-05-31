<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrestasiModel extends Model
{
    use HasFactory;

    protected $table = 'prestasi';
    protected $primaryKey = 'id_prestasi';

    protected $fillable = ['nama', 'nilai', 'id_kriteria', 'created_at', 'updated_at'];

    public function kriteria():BelongsTo{
        return $this->belongsTo(KriteriaModel::class, 'id_kriteria', 'id_kriteria');
}
}