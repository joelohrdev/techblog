<?php

declare(strict_types=1);

namespace App\Livewire\Post;

use App\Livewire\Forms\PostForm;
use App\Models\Category;
use App\Models\Post;
use Flux\Flux;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

final class Form extends Component
{
    public PostForm $form;

    public ?Post $post = null;

    public function mount(?Post $post = null): void
    {
        if ($post && $post->exists) {
            $this->post = $post;
            $this->form->setPost($post);
        }
    }

    #[Computed]
    public function categories(): Collection
    {
        return Category::query()->orderBy('name')->get();
    }

    public function createCategory(): void
    {
        if (empty($this->form->newCategoryName)) {
            return;
        }

        $this->validate(['form.newCategoryName' => 'required|string|max:255|unique:categories,name']);

        $category = Category::create([
            'name' => $this->form->newCategoryName,
            'slug' => str($this->form->newCategoryName)->slug(),
        ]);

        $this->form->selectedCategories[] = $category->id;
        $this->form->newCategoryName = '';

        unset($this->categories);

        Flux::toast(text: 'Category created successfully.', variant: 'success');
    }

    public function submit(): void
    {
        $this->form->validate();

        if ($this->post) {
            $this->update();
        } else {
            $this->store();
        }
    }

    public function render()
    {
        return view('livewire.post.form');
    }

    protected function store(): void
    {
        $post = Post::create([
            'title' => $this->form->title,
            'slug' => str($this->form->title)->slug(),
            'content' => $this->form->content,
            'summary' => $this->form->summary,
        ]);

        if (! empty($this->form->selectedCategories)) {
            $post->categories()->attach($this->form->selectedCategories);
        }

        Flux::toast(text: 'Post created successfully.', variant: 'success');

        $this->redirect(route('posts.index'), navigate: true);
    }

    protected function update(): void
    {
        $this->post->update([
            'title' => $this->form->title,
            'slug' => str($this->form->title)->slug(),
            'content' => $this->form->content,
            'summary' => $this->form->summary,
        ]);

        $this->post->categories()->sync($this->form->selectedCategories);

        Flux::toast(text: 'Post updated successfully.', variant: 'success');

        $this->redirect(route('posts.index'), navigate: true);
    }
}
