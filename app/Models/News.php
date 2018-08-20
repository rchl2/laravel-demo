<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Helpers\HasTimestamps;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasAuthor, HasTimestamps;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title', 
        'author', 
        'image', 
        'body',
    ];

    /**
     * The attributes are dates.
     */
    protected $dates = [
        'created_at', 
        'updated_at',
    ];

    public function id(): int
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function author(): string
    {
        return $this->author;
    }

    public function image(): string
    {
        return $this->image;
    }

    public function body(): string
    {
        return \Purify::clean($this->body);
    }
}
