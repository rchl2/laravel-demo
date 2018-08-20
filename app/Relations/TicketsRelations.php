<?php

namespace App\Relations;

use App\Models\TicketsAnswers;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait TicketsRelations
{
    /**
     * Return the ticket answers.
     */
    public function answersRelation(): HasMany
    {
        return $this->hasMany(TicketsAnswers::class, 'ticket_id', 'id');
    }
}
