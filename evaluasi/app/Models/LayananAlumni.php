<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayananAlumni extends Model
{
    use HasFactory;

    protected $table = 'layanan_alumnis';

    protected $fillable = ['id',
        'name',
        'prodi',
        'tahun_lulus',
        'divisi',
    ];

    public function responses()
    {
        return $this->hasMany(LayananAlumniResponse::class, 'alumni_id');
    }
}

