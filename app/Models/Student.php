<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['full_name','user_id', 'university_id', 'major','cv_file','phone_number','academic_year','gpa','training_status','supervisor_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
