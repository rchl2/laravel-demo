<?php

namespace App\Relations;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait PlayerRelations
{
    /**
     * Account relation.
     */
    public function account(): belongsTo
    {
        return $this->belongsTo(User::class, 'account_id');
    }
}
