<?php

namespace App\Models;

use App\Models\Doctor;
use App\Models\Location;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name'
    ];

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    public function locations()
    {
        return $this->hasMany(Location::class);
    }
}
