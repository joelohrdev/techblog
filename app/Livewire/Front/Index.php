<?php

namespace App\Livewire\Front;

use App\Models\Post;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Session;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Session]
    public ?int $selectedCategory = null;

    #[On('categorySelected')]
    public function filterByCategory(?int $categoryId): void
    {
        $this->selectedCategory = $categoryId;

        $this->resetPage();
    }

    #[Computed]
    public function posts()
    {
        return Post::query()
            ->when($this->selectedCategory, function ($query) {
                $query->whereHas('categories', function ($q) {
                    $q->where('categories.id', $this->selectedCategory);
                });
            })
            ->latest()
            ->paginate(10);
    }

    public function render(): View
    {
        return view('livewire.front.index');
    }
}
