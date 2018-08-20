<?php

/**
 * This is only example of policy, not belongs to this projects really.
 */

namespace App\Policies;

use App\Models\User;
use App\Models\Tickets;
use App\Queries\TicketsQueries;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the ticket.
     */
    public function view(User $user, Tickets $ticket): bool
    {
        return $ticket->isAuthoredBy($user);
    }

    /**
     * Determine whether the user can add answer to the ticket.
     */
    public function answer(User $user, Tickets $ticket): bool
    {
        return ! $ticket->isClosed($ticket) AND $ticket->isAuthoredBy($user) OR $user->isAdmin();
    }
}
