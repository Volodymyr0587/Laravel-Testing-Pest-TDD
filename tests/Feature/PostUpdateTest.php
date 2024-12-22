<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user =  User::factory()->create();
    $this->post = Post::factory()->create();
});

it('post update route exists', function () {
    $post = $this->user->posts()->create([
        'title' => 'Post Title',
        'body' => 'Post Body',
        'status' => 'pending',
    ]);

    $response = $this->actingAs($this->user)->put("/posts/{$post->id}", [
        'title' => 'New Post Title',
        'body' => 'New Post Body',
        'status' => 'published',
    ]);
    $response->assertRedirect('/posts');
});

it('unauthenticated user cannot update post', function() {
    $response = $this->put("/posts/{$this->post->id}");

    $response->assertStatus(302);
});

it('validates the post details', function () {
    $post = $this->user->posts()->create([
        'title' => 'Post Title',
        'body' => 'Post Body',
        'status' => 'pending',
    ]);

    $this->actingAs($this->user)->put("/posts/{$post->id}")
        ->assertSessionHasErrors(['title', 'body', 'status']);
});

it('abort if the user does not own the post', function () {
    $other_user = User::factory()->create();
    $post = $this->user->posts()->create([
        'title' => 'Post Title',
        'body' => 'Post Body',
        'status' => 'pending',
    ]);

    $response = $this->actingAs($other_user)->put("/posts/{$post->id}");
    $response->assertStatus(403);
});

it('can update the post', function () {
    $post = $this->user->posts()->create([
        'title' => 'Post Title',
        'body' => 'Post Body',
        'status' => 'pending',
    ]);

    $this->actingAs($this->user)->put("/posts/{$post->id}", [
        'title' => 'New Post Title',
        'body' => 'New Post Body',
        'status' => 'published',
    ])->assertRedirect('/posts');

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'title' => 'New Post Title',
        'body' => 'New Post Body',
        'status' => 'published',
    ]);
});
