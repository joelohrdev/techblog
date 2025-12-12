<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;

final class PostController extends Controller
{
    public function edit(Post $post)
    {
        return view('post.edit', [
            'post' => $post,
        ]);
    }
}
