<?php

namespace App\Relations;

use App\Models\User;
use App\Models\Player;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
