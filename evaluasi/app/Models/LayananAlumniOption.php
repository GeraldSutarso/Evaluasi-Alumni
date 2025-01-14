<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayananAlumniOption extends Model
{
    use HasFactory;

    protected $table = 'layanan_alumni_options';

    protected $fillable = [
        'id',
        'question_id',
        'value',
    ];

    public function question()
    {
        return $this->belongsTo(LayananAlumniQuestion::class, 'question_id');
    }
}
