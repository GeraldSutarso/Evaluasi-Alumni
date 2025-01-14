<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TracerStudyQuestion extends Model
{
    use HasFactory;

    protected $table = 'tracer_study_questions';

    protected $fillable = [
        'id',
        'text',
        'type',
    ];

    public function options()
    {
        return $this->hasMany(TracerStudyOption::class, 'question_id');
    }

    public function responses()
    {
        return $this->hasMany(TracerStudyResponse::class, 'question_id');
    }
}
