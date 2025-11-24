<div class="flex flex-wrap gap-3 mb-12">
    <button
        wire:click="selectCategory(null)"
        class="px-5 py-2 rounded-lg text-sm font-medium transition-all duration-300 relative overflow-hidden group {{ $selectedCategory === null ? 'text-abyssal bg-burning-flame' : 'text-oatmeal bg-blue-fantastic/30 hover:bg-blue-fantastic/60 border border-white/5' }}">
        <span class="relative z-10">All</span>
    </button>
    @foreach($this->categories as $category)
        <button
            wire:click="selectCategory({{ $category->id }})"
            class="px-5 py-2 rounded-lg text-sm font-medium transition-all duration-300 relative overflow-hidden group {{ $selectedCategory === $category->id ? 'text-abyssal bg-burning-flame' : 'text-oatmeal bg-blue-fantastic/30 hover:bg-blue-fantastic/60 border border-white/5' }} hover:cursor-pointer">
            <span class="relative z-10">{{ $category->name }}</span>
        </button>
    @endforeach
</div>
