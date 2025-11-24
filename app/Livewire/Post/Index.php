<?php

namespace App\Livewire\Post;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Computed]
    public function posts()
    {
        return Cache::remember('posts', now()->addDay(5), fn () => Post::query()->paginate(10));
    }

    public function render(): View
    {
        return view('livewire.post.index');
    }
}
