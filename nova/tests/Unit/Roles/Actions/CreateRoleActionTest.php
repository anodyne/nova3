<?php

declare(strict_types=1);
use Nova\Roles\Actions\CreateRole;
use Nova\Roles\Data\RoleData;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->disableRoleCaching();
});
it('creates a role', function () {
    $data = RoleData::from([
        'name' => 'foo',
        'display_name' => 'Foo',
        'description' => 'Description of foo',
        'default' => false,
    ]);

    $role = CreateRole::run($data);

    expect($role->exists)->toBeTrue();
    expect($role->display_name)->toEqual('Foo');
    expect($role->name)->toEqual('foo');
    expect($role->description)->toEqual('Description of foo');
    expect($role->default)->toBeFalse();
});
