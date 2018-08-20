<?php

namespace App\Jobs\Admin\Account;

use Carbon\Carbon;
use App\Models\User;
use App\Events\AccountWasBlocked;
use App\Services\FailedAttemptService;
use App\Http\Requests\Admin\Account\BlockAccountRequest;

final class BlockAccount
{
    // Status of account
    const BLOCK = 'BLOCK';
    
    private $user;
    private $data;

    public function __construct(User $user, $failedAttemptService, array $data = [])
    {
        $this->user = $user;
        $this->failedAttemptService = $failedAttemptService;
        $this->data = array_only($data, ['duration', 'duration_type', 'reason', 'ip_ban', 'admin']);
    }

    // Get data from request.
    public static function BlockAccountRequest(User $user, BlockAccountRequest $request): self
    {
        return new static($user, [
            'duration' => $request->duration(),
            'duration_type' => $request->duration_type(),
            'reason' => $request->reason(),
            'ip_ban' => $request->ip_ban(),
            'admin' => $request->admin(),
        ]);
    }

    public function handle()
    {
        // Get duration
        $duration = $this->getTypeofBan($this->data['duration_type'], $this->data['duration']);

        // Create IP ban too
        if ($this->data['ip_ban']) 
        {
            // Fixing type error when user don't have web_ip.
            if (!$this->user->web_ip())
            {
                // Check for failed attempts first (avoid of "1062 duplicate entry" error when there is ban on this IP already)
                // We're not using updateOrCreate (see: https://github.com/laravel/framework/issues/19372)
                $failedAttempt = $this->failedAttemptService->checkForFailedAttempts($this->user->web_ip());

                // Create new row or update existing.
                if (!$failedAttempt) 
                {
                    $attempt = new FailedAttempts([
                        'ip'     => $this->user->web_ip(),
                        'ending' => Carbon::now()->addDays(365),
                    ]);
        
                    $attempt->save();
                }
                else
                {
                    // Update existing row and add 365 days.
                    $failedAttempt->update(['ending' => Carbon::now()->addDays(365)]);
                }
            }
        }

        // Update user
        $this->user->update(['status' => self::BLOCK, 'blocked_by' => $this->data['admin'], 'blocked_desc' => $this->data['reason'], 'availDt' => $duration]);

        // Return
        return event(new AccountWasBlocked($this->user));
    }

    /**
     * Get type of ban.
     */
    private function getTypeOfBan(int $type, int $duration)
    {
        // Carbon
        $date = Carbon::now('Europe/Warsaw');

        // Switch for duration types
        switch ($type) 
        {
            case 1:
                $date->addHours($duration);
                break;

            case 2:
                $date->addDays($duration);
                break;

            default:
                $date->addDays($duration);
                break;
        }

        $time = $date->toDateTimeString();
        return $time;
    }
}
