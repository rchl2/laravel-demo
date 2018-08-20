<?php

namespace App\Console\Commands;

use App\Queries\UserQueries;
use Illuminate\Console\Command;
use App\Jobs\Admin\Account\UnblockAccount;
use Illuminate\Foundation\Bus\DispatchesJobs;

class DeleteExpiredBans extends Command
{
    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     */
    protected $signature = 'bans:delete';

    /**
     * The console command description.
     */
    protected $description = 'Prune expired bans on user accounts.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Search users with expired bans.
        $users = UserQueries::getWithExpiredBans();

        // Count users in collection.
        if ($users->count())
        {
            $users->each(function ($user) 
            {
                $this->dispatchNow(new UnblockAccount($user));
            });
        }
    }
}
