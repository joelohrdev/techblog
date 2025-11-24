<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($this->posts as $post)
        <a wire:navigate href="{{route('posts.show', $post)}}" class="group bg-blue-fantastic/20 backdrop-blur-md rounded-2xl p-6 border border-white/5 hover:border-burning-flame/50 transition-all cursor-pointer flex flex-col justify-between hover:translate-y-[-4px] hover:shadow-2xl hover:shadow-burning-flame/5 animate-in slide-in-from-bottom-8 fill-mode-backwards" style="animation-delay: 0ms;">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] font-mono font-bold uppercase tracking-widest text-burning-flame border border-burning-flame/20 px-2 py-1 rounded bg-burning-flame/10">
                        {{ $post->firstCategory()->name }}
                    </span>
                </div>
                <h2 class="text-xl font-bold text-palladian mb-3 group-hover:text-burning-flame transition-colors line-clamp-2">{{ $post->title }}</h2>
                <p class="text-oatmeal/70 line-clamp-3 mb-6 text-sm leading-relaxed font-light">{{ $post->summary }}</p>
            </div>
        </a>
    @endforeach
</div>
