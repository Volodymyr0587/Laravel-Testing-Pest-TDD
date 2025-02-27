<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user =  User::factory()->create();
    $this->post = Post::factory()->create();
});

it('has post edit route', function () {
    $response = $this->actingAs($this->user)->get("/posts/{$this->post->id}/edit");

    $response->assertStatus(200);
});

it('has the post details in the form', function () {
    $response = $this->actingAs($this->user)->get("/posts/{$this->post->id}/edit");

    $response->assertSee($this->post->title);
    $response->assertSee($this->post->body);
    $response->assertSee($this->post->status);

});

it('unauthenticated user cannot visit post edit page', function() {
    $response = $this->get("/posts/{$this->post->id}/edit");

    $response->assertStatus(302);
});

it('abort if the user does not own the post', function () {
    $other_user = User::factory()->create();
    $post = $this->user->posts()->create([
        'title' => 'Post Title',
        'body' => 'Post Body',
        'status' => 'pending',
    ]);

    $response = $this->actingAs($other_user)->get("/posts/{$post->id}/edit");
    $response->assertStatus(403);
});

