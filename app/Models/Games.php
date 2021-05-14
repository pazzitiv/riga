<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Games extends Model
{
    protected $table = 'games';
    public $timestamps = false;

    protected $fillable = [
        'left_team',
        'right_team',
        'left_score',
        'right_score',
        'stage',
        'release',
    ];
}
