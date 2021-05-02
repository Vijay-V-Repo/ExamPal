<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'student_id',
        'answers',
        'bookmarks',
        'started_at',
        'submitted_at',
        'current_question',
        'bookmarks',
        'marks',
    ];

    protected $casts = [
        'answers' => 'array',
        'bookmarks' => 'array',
    ];

    protected $dates = [
        'started_at',
        'submitted_at',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
