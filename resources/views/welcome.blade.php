<x-layouts.frontend
    title="{{ config('app.name') }}"
    description="Explore insightful articles on technology, web development, programming, and software engineering. Stay updated with the latest trends and best practices."
    ogType="website"
    ogTitle="{{ config('app.name') }}"
    ogDescription="Explore insightful articles on technology, web development, programming, and software engineering."
    twitterTitle="{{ config('app.name') }}"
    twitterDescription="Explore insightful articles on technology, web development, programming, and software engineering."
>
    <livewire:front.categories />
    <livewire:front.index />
</x-layouts.frontend>
