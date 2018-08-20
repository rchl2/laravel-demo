<?php

namespace App\Jobs\Admin\News;

use Auth;
use Cache;
use App\Models\News;
use App\Http\Requests\Admin\News\CreateNewsRequest;

final class CreateNews
{
    private $title;
    private $body;
    private $image;
    private $newsService;

    public function __construct(string $title, string $body, $image, $newsService)
    {
        $this->title = $title;
        $this->body = $body;
        $this->image = $image;
        $this->newsService = $newsService;
    }

    /**
     * Get data from request.
     */
    public static function CreateNewsRequest(CreateNewsRequest $request): self
    {
        return new static($request->title(), $request->body(), $request->file('image'));
    }

    public function handle()
    {
        // Handle uploaded image with service class.
        $image = $this->newsService->handleUploadedNewsImage($this->image);

        // Create news
        $news = new News([
            'title'  => $this->title,
            'body'   => $this->body,
            'image'  => $image,
            'author' => Auth::user()->id, ]);

        $news->save();

        // Flush cache
        return Cache::forget('home_news');
    }
}
