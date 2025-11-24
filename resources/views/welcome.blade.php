<x-layouts.frontend
    title="{{ config('app.name') }} - Blog"
    description="Explore insightful articles on technology, web development, programming, and software engineering. Stay updated with the latest trends and best practices."
    ogType="website"
    ogTitle="{{ config('app.name') }} - Blog"
    ogDescription="Explore insightful articles on technology, web development, programming, and software engineering."
    twitterTitle="{{ config('app.name') }} - Blog"
    twitterDescription="Explore insightful articles on technology, web development, programming, and software engineering."
>
    <livewire:front.categories />
    <livewire:front.index />
</x-layouts.frontend>
