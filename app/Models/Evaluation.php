<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;
    protected $fillable = ['company_id','student_id', 'supervisor_id','evaluation_letter','final_evaluation'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }

}
