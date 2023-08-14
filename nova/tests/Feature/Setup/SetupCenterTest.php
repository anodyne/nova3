<?php

declare(strict_types=1);

test('user can view the setup center', function () {
    $response = $this->get('/setup');
    $response->assertOk();
});
