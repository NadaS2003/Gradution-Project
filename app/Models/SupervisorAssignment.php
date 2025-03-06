<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupervisorAssignment extends Model
{
    use HasFactory;
    protected $fillable = ['student_id','supervisor_id','assigned_by'];

}
