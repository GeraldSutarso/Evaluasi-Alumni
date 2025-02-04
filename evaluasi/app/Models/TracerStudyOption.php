<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TracerStudyOption extends Model
{
    use HasFactory;

    protected $table = 'tracer_study_options';
    

    protected $fillable = [
        'id',
        'question_id',
        'value',
    ];

    public function question()
    {
        return $this->belongsTo(TracerStudyQuestion::class, 'question_id');
    }
}
