<?php

namespace App\Livewire\Post;

use App\Models\Category;
use App\Models\Post;
use Flux\Flux;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
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

    #[Computed]
    public function categories(): Collection
    {
        return Category::query()->orderBy('name')->get();
    }

    public function createCategory(): void
    {
        if (empty($this->newCategoryName)) {
            return;
        }

        $this->validate(['newCategoryName' => 'required|string|max:255|unique:categories,name']);

        $category = Category::create([
            'name' => $this->newCategoryName,
            'slug' => str($this->newCategoryName)->slug(),
        ]);

        $this->selectedCategories[] = $category->id;
        $this->newCategoryName = '';

        unset($this->categories);

        Flux::toast(text: 'Category created successfully.', variant: 'success');
    }

    public function store(): void
    {
        $this->validate();

        $post = Post::create([
            'title' => $this->title,
            'slug' => str($this->title)->slug(),
            'content' => $this->content,
            'summary' => $this->summary,
        ]);

        if (! empty($this->selectedCategories)) {
            $post->categories()->attach($this->selectedCategories);
        }

        Flux::toast(text: 'Post created successfully.', variant: 'success');

        $this->reset(['title', 'content', 'selectedCategories']);
    }

    public function render(): View
    {
        return view('livewire.post.create');
    }
}
