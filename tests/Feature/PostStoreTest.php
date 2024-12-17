<?php

it('unauthenticated user cannot create a post', function () {
    $response = $this->post('/posts');

    $response->assertStatus(302);
});

it('authenticated user can create a post', function () {
    $response = $this->actingAs(App\Models\User::factory()->create())
        ->post('/posts');

    $response->assertStatus(200);
});
