<?php

namespace App\Services;

class NewsService
{
    /**
     * Handle uploaded image for news.
     */
    public function handleUploadedNewsImage($image)
    {
        if (is_null($image)) {
            $path = 'news/images/no_image.png';
        } else {
            $path = $image->store('news/images', 'public');
        }

        return $path;
    }
}
