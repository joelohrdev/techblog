<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>{{ $title ?? config('app.name') }}</title>
    <meta name="description" content="{{ $description ?? 'Explore insightful articles on technology, development, and more.' }}" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="{{ $ogType ?? 'website' }}" />
    <meta property="og:url" content="{{ $ogUrl ?? url()->current() }}" />
    <meta property="og:title" content="{{ $ogTitle ?? $title ?? config('app.name') }}" />
    <meta property="og:description" content="{{ $ogDescription ?? $description ?? 'Explore insightful articles on technology, development, and more.' }}" />
    @if(isset($ogImage))
    <meta property="og:image" content="{{ $ogImage }}" />
    @endif

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="{{ $twitterUrl ?? url()->current() }}" />
    <meta property="twitter:title" content="{{ $twitterTitle ?? $title ?? config('app.name') }}" />
    <meta property="twitter:description" content="{{ $twitterDescription ?? $description ?? 'Explore insightful articles on technology, development, and more.' }}" />
    @if(isset($twitterImage))
    <meta property="twitter:image" content="{{ $twitterImage }}" />
    @endif

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/logo.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/frontend.css', 'resources/js/app.js'])

</head>
<body>
    <div class="min-h-screen text-palladian font-sans selection:bg-burning-flame selection:text-abyssal relative">
{{--        <x-frontend.background />--}}
        <x-frontend.header />
        <main x-data x-reveal class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{ $slot }}
        </main>
    </div>

<script>
document.addEventListener('alpine:init', () => {
    console.log('Alpine animations registered');

    // Page Load Reveal
    Alpine.directive('reveal', (el, { modifiers }) => {
        console.log('Reveal directive applied to:', el);
        const delay = modifiers.includes('delay')
            ? parseInt(modifiers[modifiers.indexOf('delay') + 1] || 0)
            : 0;

        // Set initial state
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.filter = 'blur(10px)';
        el.style.transition = 'none';

        // Force reflow
        el.offsetHeight;

        // Add transition
        el.style.transition = `opacity 0.8s cubic-bezier(0.22, 1, 0.36, 1) ${delay}ms, transform 0.8s cubic-bezier(0.22, 1, 0.36, 1) ${delay}ms, filter 0.8s cubic-bezier(0.22, 1, 0.36, 1) ${delay}ms`;

        // Animate in
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                el.style.opacity = '1';
                el.style.transform = 'translateY(0)';
                el.style.filter = 'blur(0)';
            });
        });
    });

    // Animated Text
    Alpine.directive('animated-text', (el, { expression, modifiers }, { evaluate }) => {
        const text = evaluate(expression);
        const delay = modifiers.includes('delay')
            ? parseInt(modifiers[modifiers.indexOf('delay') + 1] || 0) / 1000
            : 0;

        el.innerHTML = '';
        el.classList.add('flex', 'flex-wrap', 'gap-x-2');

        text.split(' ').forEach((word, wordIndex) => {
            const wordSpan = document.createElement('span');
            wordSpan.className = 'inline-block overflow-hidden pb-1';

            word.split('').forEach((char, charIndex) => {
                const charSpan = document.createElement('span');
                charSpan.className = 'char-reveal';
                charSpan.style.animationDelay = `${delay + (wordIndex * 0.1) + (charIndex * 0.03)}s`;
                charSpan.textContent = char;
                wordSpan.appendChild(charSpan);
            });

            el.appendChild(wordSpan);
        });
    });

    // Scroll Reveal
    Alpine.directive('scroll-reveal', (el, { modifiers }, { cleanup }) => {
        const delay = modifiers.includes('delay')
            ? parseInt(modifiers[modifiers.indexOf('delay') + 1] || 0)
            : 0;

        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.filter = 'blur(10px)';
        el.style.transition = `opacity 0.8s cubic-bezier(0.22, 1, 0.36, 1) ${delay}ms, transform 0.8s cubic-bezier(0.22, 1, 0.36, 1) ${delay}ms, filter 0.8s cubic-bezier(0.22, 1, 0.36, 1) ${delay}ms`;

        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                    el.style.filter = 'blur(0)';
                    observer.unobserve(el);
                }
            },
            { threshold: 0.1, rootMargin: '0px 0px -50px 0px' }
        );

        observer.observe(el);
        cleanup(() => observer.disconnect());
    });

    // Stagger Reveal
    Alpine.directive('stagger-reveal', (el, { modifiers }, { cleanup }) => {
        const baseDelay = modifiers.includes('delay')
            ? parseInt(modifiers[modifiers.indexOf('delay') + 1] || 0)
            : 0;
        const staggerAmount = modifiers.includes('stagger')
            ? parseInt(modifiers[modifiers.indexOf('stagger') + 1] || 100)
            : 100;

        const children = Array.from(el.children);

        children.forEach((child, index) => {
            child.style.opacity = '0';
            child.style.transform = 'translateY(20px)';
            child.style.filter = 'blur(10px)';
            child.style.transition = `opacity 0.8s cubic-bezier(0.22, 1, 0.36, 1), transform 0.8s cubic-bezier(0.22, 1, 0.36, 1), filter 0.8s cubic-bezier(0.22, 1, 0.36, 1)`;
            child.style.transitionDelay = `${baseDelay + (index * staggerAmount)}ms`;
        });

        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) {
                    children.forEach(child => {
                        child.style.opacity = '1';
                        child.style.transform = 'translateY(0)';
                        child.style.filter = 'blur(0)';
                    });
                    observer.unobserve(el);
                }
            },
            { threshold: 0.1, rootMargin: '0px 0px -50px 0px' }
        );

        observer.observe(el);
        cleanup(() => observer.disconnect());
    });
});

// Code block transformation is now handled in resources/js/syntax-highlighting.js
</script>
@fluxScripts
</body>
</html>
