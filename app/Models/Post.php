<?php

namespace App\Models;

use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** @use HasFactory<PostFactory> */
    use HasFactory;

    public function casts(): array
    {
        return [
            'id' => 'integer',
            'title' => 'string',
            'slug' => 'string',
            'content' => 'string',
            'published_at' => 'datetime',
        ];
    }
}
