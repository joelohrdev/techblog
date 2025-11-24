<?php

use App\Livewire\Post\Create;
use App\Models\Category;
use App\Models\Post;
use Livewire\Livewire;

test('component can render', function () {
    Livewire::test(Create::class)
        ->assertStatus(200);
});

test('can create post without categories', function () {
    Livewire::test(Create::class)
        ->set('title', 'Test Post')
        ->set('content', 'Test content')
        ->call('store')
        ->assertHasNoErrors();

    expect(Post::where('title', 'Test Post')->exists())->toBeTrue();
});

test('can create post with existing categories', function () {
    $categories = Category::factory()->count(3)->create();

    Livewire::test(Create::class)
        ->set('title', 'Test Post')
        ->set('content', 'Test content')
        ->set('selectedCategories', $categories->pluck('id')->toArray())
        ->call('store')
        ->assertHasNoErrors();

    $post = Post::where('title', 'Test Post')->first();
    expect($post)->not->toBeNull();
    expect($post->categories)->toHaveCount(3);
});

test('can create new category', function () {
    Livewire::test(Create::class)
        ->set('newCategoryName', 'New Category')
        ->call('createCategory')
        ->assertHasNoErrors();

    expect(Category::where('name', 'New Category')->exists())->toBeTrue();
});

test('newly created category is automatically selected', function () {
    $component = Livewire::test(Create::class)
        ->set('newCategoryName', 'New Category')
        ->call('createCategory')
        ->assertHasNoErrors();

    $category = Category::where('name', 'New Category')->first();
    expect($component->get('selectedCategories'))->toContain($category->id);
});

test('creating duplicate category fails validation', function () {
    Category::factory()->create([
        'name' => 'Existing Category',
        'slug' => 'existing-category',
    ]);

    Livewire::test(Create::class)
        ->set('newCategoryName', 'Existing Category')
        ->call('createCategory')
        ->assertHasErrors(['newCategoryName' => 'unique']);
});

test('category name is required', function () {
    Livewire::test(Create::class)
        ->set('newCategoryName', '')
        ->call('createCategory')
        ->assertHasNoErrors();

    expect(Category::count())->toBe(0);
});

test('post title is required', function () {
    Livewire::test(Create::class)
        ->set('title', '')
        ->set('content', 'Test content')
        ->call('store')
        ->assertHasErrors(['title' => 'required']);
});

test('post content is required', function () {
    Livewire::test(Create::class)
        ->set('title', 'Test Post')
        ->set('content', '')
        ->call('store')
        ->assertHasErrors(['content' => 'required']);
});

test('post slug is generated from title', function () {
    Livewire::test(Create::class)
        ->set('title', 'Test Post Title')
        ->set('content', 'Test content')
        ->call('store')
        ->assertHasNoErrors();

    $post = Post::where('title', 'Test Post Title')->first();
    expect($post->slug)->toBe('test-post-title');
});

test('category slug is generated from name', function () {
    Livewire::test(Create::class)
        ->set('newCategoryName', 'Test Category')
        ->call('createCategory')
        ->assertHasNoErrors();

    $category = Category::where('name', 'Test Category')->first();
    expect($category->slug)->toBe('test-category');
});

test('form resets after successful post creation', function () {
    $categories = Category::factory()->count(2)->create();

    $component = Livewire::test(Create::class)
        ->set('title', 'Test Post')
        ->set('content', 'Test content')
        ->set('selectedCategories', $categories->pluck('id')->toArray())
        ->call('store')
        ->assertHasNoErrors();

    expect($component->get('title'))->toBe('');
    expect($component->get('content'))->toBe('');
    expect($component->get('selectedCategories'))->toBe([]);
});
