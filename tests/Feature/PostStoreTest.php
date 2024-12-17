<?php

it('unauthenticated user cannot store a post', function () {
    $response = $this->post('/posts');

    $response->assertStatus(302);
});
