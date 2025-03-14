<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Application extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable = ['company_id','student_id','internship_id','status'];
    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
}
