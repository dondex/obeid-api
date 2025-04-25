<?php

namespace App\Models;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'department_id',
        'doctor_id',
        'user_id', 
        'subject',
        'prescription',
        'time_slot', 
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function user() 
    {
        return $this->belongsTo(User::class);
    }
}
