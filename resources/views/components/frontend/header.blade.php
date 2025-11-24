<header class="sticky top-0 z-50 bg-abyssal/80 backdrop-blur-lg border-b border-white/5">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
        <div class="w-full flex items-center justify-between gap-3 cursor-pointer group">
            <a wire:navigate href="{{ route('home') }}" class="text-2xl font-bold tracking-tighter text-palladian group-hover:text-white transition-colors">
                JOE<span class="text-burning-flame">LOHR</span>
            </a>
            @if(auth()->user())
            <a wire:navigate href="{{ route('dashboard') }}" class="relative px-3 py-1.5 bg-abyssal text-burning-flame rounded-lg border border-burning-flame transition-all duration-300 overflow-hidden group/btn before:absolute before:inset-0 before:rounded-lg before:p-[2px] before:bg-gradient-to-r before:from-burning-flame before:via-palladian before:to-burning-flame before:opacity-0 before:transition-opacity before:duration-500 hover:before:opacity-100 before:-z-10 before:animate-[spin_3s_linear_infinite] after:absolute after:inset-[2px] after:bg-abyssal after:rounded-lg after:-z-10">
                <span class="relative z-10">Backend</span>
            </a>
            @endif
        </div>
    </div>
</header>
