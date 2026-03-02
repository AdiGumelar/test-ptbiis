<?php

namespace App\Models;

use App\Models\Employees;
use Illuminate\Database\Eloquent\Model;

class Positions extends Model
{
    protected $fillable = [
        'name'
    ];

    public function employees(){
        return $this->hasMany(Employees::class);
    }
}
