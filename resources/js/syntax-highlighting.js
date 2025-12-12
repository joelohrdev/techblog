import hljs from 'highlight.js/lib/core';

// Import languages you want to support
import javascript from 'highlight.js/lib/languages/javascript';
import typescript from 'highlight.js/lib/languages/typescript';
import php from 'highlight.js/lib/languages/php';
import python from 'highlight.js/lib/languages/python';
import bash from 'highlight.js/lib/languages/bash';
import css from 'highlight.js/lib/languages/css';
import xml from 'highlight.js/lib/languages/xml'; // HTML
import json from 'highlight.js/lib/languages/json';
import sql from 'highlight.js/lib/languages/sql';
import yaml from 'highlight.js/lib/languages/yaml';
import markdown from 'highlight.js/lib/languages/markdown';
import java from 'highlight.js/lib/languages/java';
import cpp from 'highlight.js/lib/languages/cpp';
import csharp from 'highlight.js/lib/languages/csharp';
import go from 'highlight.js/lib/languages/go';
import rust from 'highlight.js/lib/languages/rust';
import ruby from 'highlight.js/lib/languages/ruby';
import swift from 'highlight.js/lib/languages/swift';
import kotlin from 'highlight.js/lib/languages/kotlin';

// Register languages
hljs.registerLanguage('javascript', javascript);
hljs.registerLanguage('js', javascript);
hljs.registerLanguage('typescript', typescript);
hljs.registerLanguage('ts', typescript);
hljs.registerLanguage('tsx', typescript);
hljs.registerLanguage('jsx', javascript);
hljs.registerLanguage('php', php);
hljs.registerLanguage('python', python);
hljs.registerLanguage('py', python);
hljs.registerLanguage('bash', bash);
hljs.registerLanguage('sh', bash);
hljs.registerLanguage('shell', bash);
hljs.registerLanguage('css', css);
hljs.registerLanguage('html', xml);
hljs.registerLanguage('xml', xml);
hljs.registerLanguage('json', json);
hljs.registerLanguage('sql', sql);
hljs.registerLanguage('yaml', yaml);
hljs.registerLanguage('yml', yaml);
hljs.registerLanguage('markdown', markdown);
hljs.registerLanguage('md', markdown);
hljs.registerLanguage('java', java);
hljs.registerLanguage('cpp', cpp);
hljs.registerLanguage('c++', cpp);
hljs.registerLanguage('c', cpp);
hljs.registerLanguage('csharp', csharp);
hljs.registerLanguage('cs', csharp);
hljs.registerLanguage('go', go);
hljs.registerLanguage('golang', go);
hljs.registerLanguage('rust', rust);
hljs.registerLanguage('rs', rust);
hljs.registerLanguage('ruby', ruby);
hljs.registerLanguage('rb', ruby);
hljs.registerLanguage('swift', swift);
hljs.registerLanguage('kotlin', kotlin);
hljs.registerLanguage('kt', kotlin);

// Transform code blocks with fancy headers and syntax highlighting
export function transformCodeBlocks() {
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

        // Apply syntax highlighting if language is registered
        if (code && hljs.getLanguage(language)) {
            try {
                const result = hljs.highlight(code.textContent, { language });
                code.innerHTML = result.value;
                code.classList.add('hljs');
            } catch (err) {
                console.error('Syntax highlighting error:', err);
            }
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
