<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAvatarAttribute($value)
    {
        return !is_null($value) ? asset(\Storage::url($value)) : asset('assets/main/images/avatar.jpg');
    }

    public function isTeacher()
    {
        return $this->role === 'teacher';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }

    public static function teachers()
    {
        return self::where('role', 'teacher')->get();
    }

    public static function students()
    {
        return self::where('role', 'student')->get();
    }

    public function createdExams()
    {
        return $this->hasMany(Exam::class, 'created_by');
    }

    public function enrolledExams()
    {
        return $this->belongsToMany(Exam::class, 'exam_student', 'student_id');
    }

    public function getExamsAttribute()
    {
        return $this->isTeacher() ? $this->createdExams : $this->enrolledExams;
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'student_id');
    }
}
