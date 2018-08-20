<?php

namespace App\Models;

use App\Helpers\HasTimestamps;
use App\Relations\PlayerRelations;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use PlayerRelations, HasTimestamps;

    /**
     * The database table used by the model.
     */
    protected $table = 'player';

    /**
     * The connection name for the model.
     */
    protected $connection = 'player';

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'account_id',
        'name',
        'job',
        'level',
        'last_play',
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [];

    /**
     * The attributes are dates.
     */
    protected $dates = [
        'last_play',
    ];

    public function id(): int
    {
        return $this->id;
    }

    public function account_id(): int
    {
        return $this->account_id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function job(): int
    {
        return $this->job;
    }

    public function level(): int
    {
        return $this->level;
    }

    public function last_play(): string
    {
        return $this->last_play;
    }

    public function isOnline(): bool
    {
        return ($this->last_play->diffInMinutes() <= 5) ? true : false;
    }
}
