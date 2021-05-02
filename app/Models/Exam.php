<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'guidelines',
        'total_time',
        'start_after',
        'due',
        'created_by',
        'image',
        'total_marks',
    ];

    protected $dates = [
        'start_after',
        'due',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getQuestionByNumber($question_no)
    {
        return $this->questions()->firstWhere('number', $question_no);
    }

    public function getImageAttribute($value)
    {
        return !is_null($value) ? asset(Storage::url($value)) : asset('assets/main/images/exam-placeholder.jpg');
    }

    public function getStartAfterAttribute($value)
    {
        return (new Carbon($value, 'Asia/Kolkata'))->format('d/m/Y  H:i');
    }

    public function getDueAttribute($value)
    {
        return (new Carbon($value, 'Asia/Kolkata'))->format('d/m/Y  H:i');
    }

    public function getStartAfterFieldAttribute($value)
    {
        return (new Carbon($value, 'Asia/Kolkata'))->format('Y-m-d\TH:m');
    }

    public function getDueFieldAttribute($value)
    {
        return (new Carbon($value, 'Asia/Kolkata'))->format('Y-m-d\TH:m');
    }

    public static function assign_exam_dropdown()
    {
        return auth()->user()
            ->createdExams()
            ->where('due', '>', now())
            ->select(['id', 'title'])
            ->get();
    }
}
