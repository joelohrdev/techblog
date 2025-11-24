<x-layouts.app :title="__('Create Post')">
    <div class="flex justify-between items-center">
        <flux:heading size="xl">Create Post</flux:heading>
        <flux:button wire:navigate href="{{ route('posts.index') }}" size="sm">Back</flux:button>
    </div>
    <flux:separator variant="subtle" class="my-4" />
    <div class="max-w-2xl mx-auto">
        <livewire:post.create />
    </div>
</x-layouts.app>
