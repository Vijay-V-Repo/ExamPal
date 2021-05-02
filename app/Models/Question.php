<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'number',
        'exam_id',
        'marks',
        'option1',
        'option2',
        'option3',
        'option4',
        'answer',
    ];

    public $timestamps = false;

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function getOptionsAttribute()
    {
        $options = [
            1 => $this->option1,
            2 => $this->option2,
        ];

        if (!is_null($this->option3)){
            $options[3] = $this->option3;

            if (!is_null($this->option4)){
                $options[4] = $this->option4;
            }
        }

        return $options;
    }
}