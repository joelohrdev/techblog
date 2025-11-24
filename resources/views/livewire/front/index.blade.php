<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($this->posts as $post)
        <a wire:navigate href="{{route('posts.show', $post)}}" class="group bg-blue-fantastic/20 backdrop-blur-md rounded-2xl p-6 border border-white/5 hover:border-burning-flame/50 transition-all cursor-pointer flex flex-col justify-between hover:translate-y-[-4px] hover:shadow-2xl hover:shadow-burning-flame/5 animate-in slide-in-from-bottom-8 fill-mode-backwards" style="animation-delay: 0ms;">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] font-mono font-bold uppercase tracking-widest text-burning-flame border border-burning-flame/20 px-2 py-1 rounded bg-burning-flame/10">Engineering</span>
                    <span class="text-oatmeal/60 text-xs font-mono flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock" aria-hidden="true">
                            <path d="M12 6v6l4 2"></path>
                            <circle cx="12" cy="12" r="10"></circle>
                        </svg> 5 min read
                    </span>
                </div>
                <h2 class="text-xl font-bold text-palladian mb-3 group-hover:text-burning-flame transition-colors line-clamp-2">{{ $post->title }}</h2>
                <p class="text-oatmeal/70 line-clamp-3 mb-6 text-sm leading-relaxed font-light">A deep dive into how RSCs change the data fetching paradigm in modern web development.</p>
            </div>
            <div class="flex items-center justify-between border-t border-white/5 pt-4 mt-auto">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded bg-gradient-to-br from-truffle-trouble to-burning-flame flex items-center justify-center text-white text-[10px] font-bold">A</div>
                    <span class="text-xs font-medium text-oatmeal">Alex Dev</span>
                </div>
                <span class="text-oatmeal/40 text-xs font-mono">11/21</span>
            </div>
        </a>
    @endforeach
</div>
