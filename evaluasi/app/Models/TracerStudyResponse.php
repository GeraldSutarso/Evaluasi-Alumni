<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TracerStudyResponse extends Model
{
    use HasFactory;

    protected $table = 'tracer_study_responses';

    protected $fillable = [
        'id',
        'alumni_id',
        'question_id',
        'response_value',
    ];

    public function alumni()
    {
        return $this->belongsTo(TracerStudy::class, 'alumni_id');
    }

    public function question()
    {
        return $this->belongsTo(TracerStudyQuestion::class, 'question_id');
    }
}
