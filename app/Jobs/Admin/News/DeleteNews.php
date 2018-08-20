<?php

namespace App\Jobs\Admin\News;

use Cache;
use App\Models\News;

final class DeleteNews
{
    private $news;

    public function __construct(News $news)
    {
        $this->news = $news;
    }

    public function handle()
    {
        $this->news->delete();

        // Flush cache
        return Cache::forget('home_news');
    }
}
