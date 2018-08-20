<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasAdmin
{
    public function admin(): ?User
    {
        return $this->adminRelation;
    }

    public function adminRelation(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin');
    }
}
