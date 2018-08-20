<?php

namespace App\Jobs\Admin\News;

use Cache;
use App\Models\News;
use App\Http\Requests\Admin\News\UpdateNewsRequest;

final class UpdateNews
{
    private $news;
    private $data;

    public function __construct(News $news, array $data = [])
    {
        $this->news = $news;
        $this->data = array_only($data, ['title', 'body']);
    }

    // Get data from request.
    public static function UpdateNewsRequest(News $news, UpdateNewsRequest $request): self
    {
        return new static($news, [
            'title' => $request->title(),
            'body'  => $request->body(),
        ]);
    }

    public function handle(): News
    {
        $this->news->update($this->data);
        
        // Flush cache and return news.
        Cache::forget('home_news');
        
        return $this->news;
    }
}
