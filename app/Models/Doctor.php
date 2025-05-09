<?php

namespace App\Models;

use App\Models\Department;
use App\Models\Location;
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

    public function locations()
    {
        return $this->hasMany(Location::class);
    }
   
}
