<?php

namespace App\Livewire\Post;

use App\Models\Post;
use Flux\Flux;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    #[Validate(['required', 'string', 'max:255'])]
    public string $title = '';
    #[Validate(['required', 'string', 'max:255'])]
    public string $content = '';

    public function store(): void
    {
        $this->validate();

        Post::create([
            'title' => $this->title,
            'slug' => str($this->title)->slug(),
            'content' => $this->content,
        ]);

        Flux::toast(text: 'Post created successfully.', variant: 'success');

        $this->reset(['title', 'content']);
    }

    public function render(): View
    {
        return view('livewire.post.create');
    }
}
