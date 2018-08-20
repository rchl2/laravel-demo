<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasAuthor
{
    public function author(): User
    {
        return $this->authorRelation;
    }

    public function authorRelation(): belongsTo
    {
        return $this->belongsTo(User::class, 'author');
    }

    public function isAuthoredBy(User $user): bool
    {
        return $this->author === $user->id;
    }
}
