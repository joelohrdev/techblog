<?php

namespace App\Livewire\Post;

use App\Models\Post;
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
        return Post::query()->latest()->paginate(10);
    }

    public function render(): View
    {
        return view('livewire.post.index');
    }
}
