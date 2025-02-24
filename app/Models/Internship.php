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

}
