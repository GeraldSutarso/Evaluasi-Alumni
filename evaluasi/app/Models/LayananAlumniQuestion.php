<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayananAlumniQuestion extends Model
{
    use HasFactory;
    protected $fillable = ['id',
        'text',
        'type',
    ];
    public $timestamps = false;
    public function options()
    {
        return $this->hasMany(LayananAlumniOption::class, 'question_id');
    }

    public function responses()
    {
        return $this->hasMany(LayananAlumniResponse::class, 'question_id');
    }
    protected $table = 'layanan_alumni_questions';
}
