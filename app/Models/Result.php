<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = ['class', 'roll', 'subjects_marks'];

    protected $casts = [
        'subjects_marks' => 'array', // Cast the subjects_marks field as an array
    ];
}
