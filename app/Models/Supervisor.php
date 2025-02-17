<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    use HasFactory;

    protected $fillable = ['full_name','user_id', 'employee_id','phone_number','department'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
