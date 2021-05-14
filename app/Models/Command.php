<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class Command extends Model
{
    use HasFactory, HasTimestamps;

    protected $table = 'commands';

    protected $fillable = [
        'id',
        'name',
        'division_id',
        'created_at',
        'updated_at',
    ];

    public function division(): HasOne
    {
        return $this->hasOne(Division::class, 'id', 'division_id');
    }

    public function games(): HasMany
    {
        return $this
            ->hasMany(Games::class, 'left_team', 'id')
            ->leftJoinSub(DB::table($this->table)->select('id as right_id', 'name as right_name'), 'rival', 'rival.right_id', '=', 'right_team');
    }
}
