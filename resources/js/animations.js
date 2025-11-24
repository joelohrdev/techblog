/**
 * Global Alpine.js Animations
 *
 * Usage:
 * - Animated Text: x-animated-text="'Your text here'" or with delay x-animated-text.delay.500="'Text'"
 * - Scroll Reveal: x-scroll-reveal or x-scroll-reveal.delay.200
 * - Page Load Reveal: x-reveal or x-reveal.delay.200
 */

// Register as an Alpine plugin
window.AlpineAnimations = function (Alpine) {
    // Page Load Reveal - Animates on page load with optional delay
    Alpine.directive('reveal', (el, { modifiers }) => {
        const delay = modifiers.includes('delay')
            ? parseInt(modifiers[modifiers.indexOf('delay') + 1] || 0)
            : 0;

        // Determine direction
        let animationClass = 'animate-reveal-up';
        if (modifiers.includes('down')) animationClass = 'animate-reveal-down';
        if (modifiers.includes('left')) animationClass = 'animate-reveal-left';
        if (modifiers.includes('right')) animationClass = 'animate-reveal-right';

        el.classList.add(animationClass);
        el.style.animationDelay = `${delay}ms`;

        // Start animation after a tiny delay to ensure CSS is applied
        requestAnimationFrame(() => {
            el.classList.add('running');
        });
    });

    // Page Load Reveal data component for more control
    Alpine.data('reveal', (options = {}) => ({
        isVisible: false,
        delay: options.delay || 0,

        init() {
            setTimeout(() => {
                this.isVisible = true;
            }, this.delay);
        }
    }));
    // Animated Text - Character by character reveal
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

    // Scroll Reveal - Animate when element enters viewport
    Alpine.directive('scroll-reveal', (el, { modifiers }, { cleanup }) => {
        const delay = modifiers.includes('delay')
            ? parseInt(modifiers[modifiers.indexOf('delay') + 1] || 0)
            : 0;

        // Set initial state
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = `opacity 0.6s cubic-bezier(0.22, 1, 0.36, 1) ${delay}ms, transform 0.6s cubic-bezier(0.22, 1, 0.36, 1) ${delay}ms`;

        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                    observer.unobserve(el);
                }
            },
            {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            }
        );

        observer.observe(el);

        cleanup(() => observer.disconnect());
    });

    // Alpine data component for more control
    Alpine.data('scrollReveal', (options = {}) => ({
        isVisible: false,
        delay: options.delay || 0,

        init() {
            const observer = new IntersectionObserver(
                ([entry]) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            this.isVisible = true;
                        }, this.delay);
                        observer.unobserve(this.$el);
                    }
                },
                {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px'
                }
            );

            observer.observe(this.$el);
        }
    }));

    // Staggered children reveal
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
            child.style.transition = `opacity 0.6s cubic-bezier(0.22, 1, 0.36, 1), transform 0.6s cubic-bezier(0.22, 1, 0.36, 1)`;
            child.style.transitionDelay = `${baseDelay + (index * staggerAmount)}ms`;
        });

        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) {
                    children.forEach(child => {
                        child.style.opacity = '1';
                        child.style.transform = 'translateY(0)';
                    });
                    observer.unobserve(el);
                }
            },
            {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            }
        );

        observer.observe(el);

        cleanup(() => observer.disconnect());
    });
};

// Auto-register when Alpine initializes
document.addEventListener('alpine:init', () => {
    window.AlpineAnimations(window.Alpine);
});

// Fallback: if Alpine already started, register now
if (window.Alpine) {
    window.AlpineAnimations(window.Alpine);
}
