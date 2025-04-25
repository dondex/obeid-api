<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class LabResult extends Model
{
    

    protected $fillable = [
        'user_id', 
        'result_type',
        'result_data',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
