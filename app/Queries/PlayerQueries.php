<?php

namespace App\Queries;

use App\Models\Player;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\Paginator;

final class PlayerQueries
{
    /**
     * Get players for sidebar ranklist.
     */
    public static function getForSidebarRanklist(int $count): Collection
    {
        $players = Cache::remember('players_ranking_sidebar', '8', function () use ($count) 
        {
            // Skip prefixes on players
            $whereData = [
                ['name', 'NOT LIKE', '[TEAM]%'],
                ['name', 'NOT LIKE', '[GM]%'],
                ['name', 'NOT LIKE', '[GA]%'],
                ['name', 'NOT LIKE', '[DEV]%'],
                ['name', 'NOT LIKE', '[TUT]%'],
            ];

            return Player::where($whereData)
                ->select('name', 'level')
                ->orderBy('level', 'desc')
                ->take($count)
                ->get();
        });

        return $players;
    }
}
