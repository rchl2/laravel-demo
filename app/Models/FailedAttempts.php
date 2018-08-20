<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FailedAttempts extends Model
{
    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * Set primary key for this table.
     */
    protected $primaryKey = 'ip';

    /**
     * Disable incrementing for this table.
     */
    public $incrementing = false;

    /**
     * The database table used by the model.
     */
    protected $table = 'failed_attempts';

    /**
     * The connection name for the model.
     */
    protected $connection = 'account';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'ip', 'ending',
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'attempts',
    ];

    /**
     * The attributes are dates.
     */
    protected $dates = [
        'ending',
    ];

    /**
     * Default attributes.
     */
    protected $attributes = [
        'attempts' => 0,
    ];
}
