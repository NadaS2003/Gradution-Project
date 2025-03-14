<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Company extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable = ['company_name','user_id', 'website','description','location','phone_number'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
}

