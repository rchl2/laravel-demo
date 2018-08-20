<?php

namespace App\Queries;

use App\Models\News;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\Paginator;

final class NewsQueries
{
    /**
     * Get latest news, paginate results.
     * Include author (relation) and get login with autor account ID.
     */
    public static function latestPaginated(int $perPage = 15): Paginator
    {
        return News::latest()
            ->with(['authorRelation' => function ($query) {
                $query->select('login', 'id');
            }])
            ->simplePaginate($perPage);
    }

    /**
     * Get latests news from cache instance or put latest into cache and return results.
     * Include author (relation) and get login with author account ID.
     */
    public static function latestForHomepage(int $count = 3): Collection
    {
        $news = Cache::remember('home_news', '15', function () use ($count) {
            return News::latest()
                ->with(['authorRelation' => function ($query) {
                    $query->select('login', 'id');
                }])
                ->take($count)
                ->get();
        });

        return $news;
    }
}
