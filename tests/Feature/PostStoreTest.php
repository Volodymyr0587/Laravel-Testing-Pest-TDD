<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('unauthenticated user cannot create a post', function () {
    $response = $this->post('/posts');

    $response->assertStatus(302);
});

it('authenticated user can create a post', function () {
    $user = User::factory()->create();
    $response = $this->actingAs($user)
        ->post('/posts', [
            'user_id' => $user->id,
            'title' => 'test title',
            'body' => 'test body',
            'status' => 'is_published',
        ]);

    $response->assertRedirect('/');
    $this->assertDatabaseHas('posts', [
        'title' => 'test title',
        'body' => 'test body',
        'status' => 'is_published',
    ]);
});

it('requires title, body and status', function () {
    $user = User::factory()->create();
    $this->actingAs($user)->post('/posts')->assertSessionHasErrors([
        'title', 'body', 'status',
    ]);
});


