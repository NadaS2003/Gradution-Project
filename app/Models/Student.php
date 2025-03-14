<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Student extends Model
{
    use HasFactory;
    use Notifiable;
    protected $fillable = ['full_name','user_id', 'university_id', 'major','cv_file','phone_number','academic_year','gpa','training_status','supervisor_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    public function supervisor()
    {
        return $this->belongsToMany(Supervisor::class, 'supervisor_assignments', 'student_id', 'supervisor_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function internships()
    {
        return $this->hasMany(Internship::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function weeklyEvaluations()
    {
        return $this->hasMany(WeeklyEvaluation::class);
    }
}
