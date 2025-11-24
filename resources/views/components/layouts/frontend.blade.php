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

// Transform code blocks with fancy headers
function transformCodeBlocks() {
    document.querySelectorAll('.markdown-body pre').forEach(pre => {
        // Skip if already wrapped
        if (pre.parentElement.classList.contains('code-block-wrapper')) {
            return;
        }

        // Get language from various sources
        const code = pre.querySelector('code');
        let language = null;

        if (code) {
            // Try class="language-tsx"
            if (code.className) {
                const match = code.className.match(/(?:language|lang)-(\w+)/);
                if (match) {
                    language = match[1];
                }
            }

            // Try data-language attribute
            if (!language && code.dataset.language) {
                language = code.dataset.language;
            }

            // Try pre's data-language attribute
            if (!language && pre.dataset.language) {
                language = pre.dataset.language;
            }
        }

        // Default to 'code' if no language detected
        if (!language) {
            language = 'code';
        }

        // Create wrapper
        const wrapper = document.createElement('div');
        wrapper.className = 'code-block-wrapper';

        // Create header
        const header = document.createElement('div');
        header.className = 'code-block-header';
        header.innerHTML = `
            <span class="language-label">${language}</span>
            <div class="flex items-center gap-3">
                <button class="copy-button group" aria-label="Copy code">
                    <svg class="copy-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="14" height="14" x="8" y="8" rx="2" ry="2"/>
                        <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/>
                    </svg>
                    <svg class="check-icon hidden" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                </button>
                <div class="window-dots">
                    <div class="dot dot-red"></div>
                    <div class="dot dot-yellow"></div>
                    <div class="dot dot-green"></div>
                </div>
            </div>
        `;

        // Wrap the pre element
        pre.parentNode.insertBefore(wrapper, pre);
        wrapper.appendChild(header);
        wrapper.appendChild(pre);

        // Add copy functionality
        const copyButton = header.querySelector('.copy-button');
        const copyIcon = copyButton.querySelector('.copy-icon');
        const checkIcon = copyButton.querySelector('.check-icon');

        copyButton.addEventListener('click', async () => {
            const codeText = code ? code.textContent : pre.textContent;

            try {
                await navigator.clipboard.writeText(codeText);

                // Show check icon
                copyIcon.classList.add('hidden');
                checkIcon.classList.remove('hidden');

                // Reset after 2 seconds
                setTimeout(() => {
                    copyIcon.classList.remove('hidden');
                    checkIcon.classList.add('hidden');
                }, 2000);
            } catch (err) {
                console.error('Failed to copy code:', err);
            }
        });
    });
}

// Run on initial page load
document.addEventListener('DOMContentLoaded', transformCodeBlocks);

// Run after Livewire navigation
document.addEventListener('livewire:navigated', transformCodeBlocks);
</script>
@fluxScripts
</body>
</html>
