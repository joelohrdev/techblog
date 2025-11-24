<?php

declare(strict_types=1);

namespace App\Livewire\Front;

use App\Models\Category;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Session;
use Livewire\Component;

final class Categories extends Component
{
    #[Session]
    public ?int $selectedCategory = null;

    public function selectCategory(?int $categoryId): void
    {
        $this->selectedCategory = $categoryId;
        $this->dispatch('categorySelected', categoryId: $categoryId);
    }

    #[Computed]
    public function categories()
    {
        return Category::query()->orderBy('name')->get();
    }

    public function render(): View
    {
        return view('livewire.front.categories');
    }
}
