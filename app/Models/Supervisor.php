<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Supervisor extends Model
{
    use HasFactory;
    use Notifiable;
    protected $fillable = ['full_name','user_id', 'employee_id','phone_number','department'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function students()
    {
        return $this->belongsToMany(Student::class, 'supervisor_assignments', 'supervisor_id', 'student_id');
    }

}
