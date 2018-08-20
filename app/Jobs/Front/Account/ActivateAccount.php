<?php

namespace App\Jobs\Front\Account;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

final class ActivateAccount implements ShouldQueue
{
    use InteractsWithQueue, Queueable;

    // Status of account
    const OK = 'OK';

    public $tries = 2;
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        return $this->user->update(['status' => self::OK]);
    }
}
