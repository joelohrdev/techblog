<form wire:submit.prevent="submit" class="space-y-6">
    <flux:input wire:model="form.title" placeholder="Title" label="Title" />

    <flux:pillbox
        wire:model="form.selectedCategories"
        label="Categories"
        placeholder="Select categories..."
        searchable
        multiple
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
                wire:model="form.newCategoryName"
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

    <flux:editor wire:model="form.content" label="Content" />

    <flux:input wire:model="form.summary" placeholder="Summary" label="Summary" />

    <flux:button type="submit" variant="primary">
        {{ $post ? 'Update Post' : 'Create Post' }}
    </flux:button>
</form>
