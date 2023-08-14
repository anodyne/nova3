<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Ranks\Models\RankName;
beforeEach(function () {
    $this->name = RankName::factory()->create();
});
test('authorized user can view a rank name', function () {
    $this->signInWithPermission('rank.view');

    $response = $this->get(route('ranks.names.show', $this->name));
    $response->assertSuccessful();
    $response->assertViewHas('name', $this->name);
});
test('unauthorized user cannot view a rank name', function () {
    $this->signIn();

    $response = $this->get(route('ranks.names.show', $this->name));
    $response->assertForbidden();
});
test('unauthenticated user cannot view a rank name', function () {
    $response = $this->getJson(route('ranks.names.show', $this->name));
    $response->assertUnauthorized();
});
