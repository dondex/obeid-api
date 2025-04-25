<?php

namespace App\Models;

use App\Models\Department;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'name',
        'department_id',
        'doctor_image',
        'available_time_slot'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
