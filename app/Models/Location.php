<?php

namespace App\Models;

use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'name',
        'image',
        'department_id',
        'doctor_id'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
