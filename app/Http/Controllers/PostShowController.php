<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;

final class PostShowController extends Controller
{
    public function __invoke(Post $post)
    {
        return view('front.post.show', [
            'post' => $post,
        ]);
    }
}
