<div>
<flux:table>
    <flux:table.columns>
        <flux:table.column>Title</flux:table.column>
    </flux:table.columns>
    <flux:table.rows>
        @foreach($this->posts as $post)
            <flux:table.row>
                <flux:table.cell>{{ $post->title }}</flux:table.cell>
            </flux:table.row>
        @endforeach
    </flux:table.rows>
</flux:table>
</div>
