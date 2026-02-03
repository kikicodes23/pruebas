<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'carnet',
        'name',
        'lastname',
        'email',
        'career',
    ];

    public function registers(){
        return $this->hasMany(Register::class);
    }
}
