<form wire:submit.prevent="store" class="space-y-6">
    <flux:input wire:model="title" placeholder="Title" label="Title" />

    <flux:pillbox
        wire:model="selectedCategories"
        label="Categories"
        placeholder="Select categories..."
        searchable
    >
        @foreach($this->categories as $category)
            <flux:pillbox.option value="{{ $category->id }}">{{ $category->name }}</flux:pillbox.option>
        @endforeach
    </flux:pillbox>

    <flux:separator variant="subtle" />

    <div class="space-y-3">
        <flux:heading size="sm">Create New Category</flux:heading>
        <div class="flex gap-3">
            <flux:input
                wire:model="newCategoryName"
                placeholder="New category name..."
                class="flex-1"
            />
            <flux:button
                wire:click="createCategory"
                type="button"
                variant="outline"
            >
                Add Category
            </flux:button>
        </div>
    </div>

    <flux:separator variant="subtle" />

    <flux:editor wire:model="content" label="Content" />

    <flux:input wire:model="summary" placeholder="Summary" label="Summary" />

    <flux:button type="submit" variant="primary">Create Post</flux:button>
</form>
