<x-layouts.frontend>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="animate-reveal-up running " style="animation-delay: 0s; width: 100%;">
            <a wire:navigate href="{{ route('home') }}" class="group mb-12 flex items-center text-oatmeal hover:text-burning-flame transition-colors font-mono text-xs uppercase tracking-wide">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left mr-2 group-hover:-translate-x-1 transition-transform" aria-hidden="true"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
                Return to Grid
            </a>
        </div>
        <header class="mb-12 border-b border-white/10 pb-8">
            <h1 class="flex flex-wrap gap-x-2 text-2xl sm:text-6xl font-bold text-palladian mb-8 leading-tight">
                {{ $post->title }}
            </h1>
        </header>
        <article class="min-h-[400px]">
            <div class="animate-reveal-up running " style="animation-delay: 0.6s; width: 100%;">
                <div class="markdown-body">
                    {!! $post->content !!}
                </div>
            </div>
        </article>
    </div>
</x-layouts.frontend>
