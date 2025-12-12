<?php

declare(strict_types=1);

use App\Livewire\Post\Form;
use App\Models\Category;
use App\Models\Post;
use Livewire\Livewire;

test('component can render', function () {
    Livewire::test(Form::class)
        ->assertStatus(200);
});

test('can create post without categories', function () {
    Livewire::test(Form::class)
        ->set('form.title', 'Test Post')
        ->set('form.content', 'Test content')
        ->set('form.summary', 'Test summary')
        ->call('submit')
        ->assertHasNoErrors();

    expect(Post::where('title', 'Test Post')->exists())->toBeTrue();
});

test('can create post with existing categories', function () {
    $categories = Category::factory()->count(3)->create();

    Livewire::test(Form::class)
        ->set('form.title', 'Test Post')
        ->set('form.content', 'Test content')
        ->set('form.summary', 'Test summary')
        ->set('form.selectedCategories', $categories->pluck('id')->toArray())
        ->call('submit')
        ->assertHasNoErrors();

    $post = Post::where('title', 'Test Post')->first();
    expect($post)->not->toBeNull();
    expect($post->categories)->toHaveCount(3);
});

test('can create new category', function () {
    Livewire::test(Form::class)
        ->set('form.newCategoryName', 'New Category')
        ->call('createCategory')
        ->assertHasNoErrors();

    expect(Category::where('name', 'New Category')->exists())->toBeTrue();
});

test('newly created category is automatically selected', function () {
    $component = Livewire::test(Form::class)
        ->set('form.newCategoryName', 'New Category')
        ->call('createCategory')
        ->assertHasNoErrors();

    $category = Category::where('name', 'New Category')->first();
    expect($component->get('form.selectedCategories'))->toContain($category->id);
});

test('creating duplicate category fails validation', function () {
    Category::factory()->create([
        'name' => 'Existing Category',
        'slug' => 'existing-category',
    ]);

    Livewire::test(Form::class)
        ->set('form.newCategoryName', 'Existing Category')
        ->call('createCategory')
        ->assertHasErrors(['form.newCategoryName' => 'unique']);
});

test('category name is required', function () {
    Livewire::test(Form::class)
        ->set('form.newCategoryName', '')
        ->call('createCategory')
        ->assertHasNoErrors();

    expect(Category::count())->toBe(0);
});

test('post title is required', function () {
    Livewire::test(Form::class)
        ->set('form.title', '')
        ->set('form.content', 'Test content')
        ->call('submit')
        ->assertHasErrors(['form.title' => 'required']);
});

test('post content is required', function () {
    Livewire::test(Form::class)
        ->set('form.title', 'Test Post')
        ->set('form.content', '')
        ->call('submit')
        ->assertHasErrors(['form.content' => 'required']);
});

test('post slug is generated from title', function () {
    Livewire::test(Form::class)
        ->set('form.title', 'Test Post Title')
        ->set('form.content', 'Test content')
        ->set('form.summary', 'Test summary')
        ->call('submit')
        ->assertHasNoErrors();

    $post = Post::where('title', 'Test Post Title')->first();
    expect($post->slug)->toBe('test-post-title');
});

test('category slug is generated from name', function () {
    Livewire::test(Form::class)
        ->set('form.newCategoryName', 'Test Category')
        ->call('createCategory')
        ->assertHasNoErrors();

    $category = Category::where('name', 'Test Category')->first();
    expect($category->slug)->toBe('test-category');
});
