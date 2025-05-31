<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganisasiModel extends Model
{
    use HasFactory;

    protected $table = 'organisasi';
    protected $primaryKey = 'id_organisasi';

    protected $fillable = ['nama', 'nilai', 'id_kriteria', 'created_at', 'updated_at'];

    public function kriteria():BelongsTo{
        return $this->belongsTo(KriteriaModel::class, 'id_kriteria', 'id_kriteria');
}
}
