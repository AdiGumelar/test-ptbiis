<?php

namespace App\Models;

use App\Models\Positions;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    protected $fillable = [
        'employee_code',
        'positions_id',
        'name',
        'email',
        'phone',
        'gender',
        'birth_place',
        'birth_date',
        'hire_date',
        'salary',
        'status',
        'photo'
    ];

    public function positions(){
        return $this->belongsTo(Positions::class, 'positions_id');
    }
}
