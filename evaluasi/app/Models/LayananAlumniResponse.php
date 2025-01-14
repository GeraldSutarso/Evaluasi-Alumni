<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayananAlumniResponse extends Model
{
    use HasFactory;

    protected $table = 'layanan_alumni_responses';

    protected $fillable = [
        'id',
        'alumni_id',
        'question_id',
        'response_value',
    ];

    public function alumni()
    {
        return $this->belongsTo(LayananAlumni::class, 'alumni_id');
    }

    public function question()
    {
        return $this->belongsTo(LayananAlumniQuestion::class, 'question_id');
    }
}
