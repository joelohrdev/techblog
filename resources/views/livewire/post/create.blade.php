<form wire:submit.prevent="store" class="space-y-6">
    <flux:input wire:model="title" placeholder="Title" />
    <flux:editor wire:model="content" />
    <flux:button type="submit" variant="primary">Create</flux:button>
</form>
