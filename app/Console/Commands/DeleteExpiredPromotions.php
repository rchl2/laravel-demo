<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Queries\ShopPromotionsQueries;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Jobs\Admin\ShopPromotions\DeletePromotion;

class DeleteExpiredPromotions extends Command
{
    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     */
    protected $signature = 'promotions:delete';

    /**
     * The console command description.
     */
    protected $description = 'Prune expired promotions.';

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
        // Search for promotions
        $promotions = ShopPromotionsQueries::getExpired();

        // Count items in collection
        if ($promotions->count()) {
            $promotions->each(function ($promotion) {
                $this->dispatchNow(new DeletePromotion($promotion));
            });
        }
    }
}
