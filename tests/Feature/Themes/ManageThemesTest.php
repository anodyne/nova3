<?php

uses()->group('feature', 'themes');

test('authorized user can manage themes')
    ->signInWithPermission('theme.create')
    ->get('/themes')
    ->assertSuccessful();

test('unauthorized user cannot manage themes')
    ->signIn()
    ->get('/themes')
    ->assertForbidden();

test('guest cannot manage themes')
    ->get('/themes')
    ->assertRedirect('/login');
