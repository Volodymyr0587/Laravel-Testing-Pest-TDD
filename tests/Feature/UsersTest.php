<?php

it('has welcome page', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
