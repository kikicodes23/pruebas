<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'semester_number'
    ];

    public function registers(){
        return $this->hasMany(Register::class);
    }
}
