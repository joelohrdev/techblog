<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use App\Models\Post;
use Livewire\Attributes\Validate;
use Livewire\Form;

final class PostForm extends Form
{
    #[Validate(['required', 'string', 'max:255'])]
    public string $title = '';

    #[Validate(['required', 'string'])]
    public string $content = '';

    #[Validate(['required', 'string'])]
    public string $summary = '';

    #[Validate(['array'])]
    public array $selectedCategories = [];

    #[Validate(['nullable', 'string', 'max:255'])]
    public string $newCategoryName = '';

    public function setPost(Post $post): void
    {
        $this->title = $post->title;
        $this->content = $post->content;
        $this->summary = $post->summary;
        $this->selectedCategories = $post->categories()->pluck('id')->toArray();
    }
}
