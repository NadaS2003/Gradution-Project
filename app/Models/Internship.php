<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    use HasFactory;
    protected $fillable = ['company_id','title', 'description','start_date','end_date','duration','status','image' ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'internship_id');
    }


    public function application()
    {
        return $this->hasOne(Application::class);
    }

    public function weeklyEvaluations()
    {
        return $this->hasMany(WeeklyEvaluation::class, 'internship_id');
    }
}
