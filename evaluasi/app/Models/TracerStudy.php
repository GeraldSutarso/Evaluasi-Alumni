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
        'divisi',
        'tahun_lulus',
    ];

    public function responses()
    {
        return $this->hasMany(TracerStudyResponse::class, 'alumni_id');
    }
}

