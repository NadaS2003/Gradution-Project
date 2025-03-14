<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyEvaluation extends Model
{
    use HasFactory;
    protected $fillable = ['student_id', 'company_id', 'week_name', 'evaluation'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }



}
