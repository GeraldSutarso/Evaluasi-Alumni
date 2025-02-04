<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TracerStudy extends Model
{
    use HasFactory;

    protected $table = 'tracer_studies';

    protected $fillable = [
        'id',
        'name',
        'prodi',
        'divisi',
        'tahun_lulus',
        'department',
        'tempat',
        'plant',
        'created_at',
        'updated_at',
    ];

    public function responses()
    {
        return $this->hasMany(TracerStudyResponse::class, 'alumni_id');
    }
}

