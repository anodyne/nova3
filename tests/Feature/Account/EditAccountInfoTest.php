<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Nova\Stories\Enums\ContentRatingValue;
use Nova\Users\Enums\Appearance;
use Nova\Users\Livewire\MyAccount;
use Nova\Users\Models\User;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

uses()->group('account');

beforeEach(function () {
    signIn([
        'pronouns->value' => 'female',
        'pronouns->subject' => 'she',
        'pronouns->object' => 'her',
    ]);

    $this->user = Auth::user();
});

test('a user can view their account info', function () {
    get(route('admin.account.edit'))
        ->assertSuccessful()
        ->assertSeeLivewire(MyAccount::class);

    livewire(MyAccount::class)
        ->assertSet('form.name', $this->user->name)
        ->assertSet('form.email', $this->user->email)
        ->assertSet('form.currentPassword', '')
        ->assertSet('form.newPassword', '')
        ->assertSet('form.newPasswordConfirmation', '')
        ->assertSet('form.pronouns', $this->user->pronouns->value)
        ->assertSet('form.pronounSubject', $this->user->pronouns->subject)
        ->assertSet('form.pronounObject', $this->user->pronouns->object)
        ->assertSet('form.timezone', 'UTC')
        ->assertSet('form.appearance', Appearance::Light)
        ->assertSet('form.languageContentRatingWarningThreshold', ContentRatingValue::Game)
        ->assertSet('form.sexContentRatingWarningThreshold', ContentRatingValue::Game)
        ->assertSet('form.violenceContentRatingWarningThreshold', ContentRatingValue::Game);
});

test('a user can update multiple fields at once', function () {
    livewire(MyAccount::class)
        ->set('form.name', 'Jane Smith')
        ->set('form.email', 'jane@example.com')
        ->set('form.pronouns', 'neutral')
        ->set('form.timezone', 'America/Los_Angeles')
        ->set('form.appearance', Appearance::Dark)
        ->set('form.languageContentRatingWarningThreshold', ContentRatingValue::Level1)
        ->set('form.sexContentRatingWarningThreshold', ContentRatingValue::Level2)
        ->set('form.violenceContentRatingWarningThreshold', ContentRatingValue::Level3)
        ->call('save')
        ->assertHasNoErrors()
        ->assertNotified();

    assertDatabaseHas(User::class, [
        'id' => $this->user->id,
        'name' => 'Jane Smith',
        'email' => 'jane@example.com',
        'pronouns->value' => 'neutral',
        'pronouns->subject' => 'they',
        'pronouns->object' => 'them',
        'preferences->timezone' => 'America/Los_Angeles',
        'preferences->appearance' => 'dark',
        'preferences->languageContentRatingWarningThreshold' => '1',
        'preferences->sexContentRatingWarningThreshold' => '2',
        'preferences->violenceContentRatingWarningThreshold' => '3',
    ]);
});

test('updating account info preserves other preferences', function () {
    $this->user->update([
        'preferences' => [
            'timezone' => 'America/New_York',
            'appearance' => 'dark',
            'languageContentRatingWarningThreshold' => '2',
            'sexContentRatingWarningThreshold' => '3',
            'violenceContentRatingWarningThreshold' => '1',
        ],
    ]);

    livewire(MyAccount::class)
        ->set('form.name', 'New Name')
        ->call('save')
        ->assertHasNoErrors();

    $this->user->refresh();

    expect($this->user->name)->toBe('New Name');
    expect($this->user->preferences->timezone)->toBe('America/New_York');
    expect($this->user->preferences->appearance->value)->toBe('dark');
    expect($this->user->preferences->languageContentRatingWarningThreshold->value)->toBe('2');
});

describe('validation', function () {
    test('name is required', function () {
        livewire(MyAccount::class)
            ->set('form.name', '')
            ->call('save')
            ->assertHasErrors(['form.name' => 'required']);
    });

    test('email is required', function () {
        livewire(MyAccount::class)
            ->set('form.email', '')
            ->call('save')
            ->assertHasErrors(['form.email' => 'required']);
    });

    test('email must be valid', function () {
        livewire(MyAccount::class)
            ->set('form.email', 'not-an-email')
            ->call('save')
            ->assertHasErrors(['form.email' => 'email']);
    });

    test('timezone is required', function () {
        livewire(MyAccount::class)
            ->set('form.timezone', '')
            ->call('save')
            ->assertHasErrors(['form.timezone' => 'required']);
    });
});

describe('appearance', function () {
    test('a user can update their appearance preference', function () {
        assertDatabaseHas(User::class, [
            'id' => $this->user->id,
            'preferences->appearance' => 'light',
        ]);

        livewire(MyAccount::class)
            ->set('form.appearance', Appearance::Dark)
            ->call('save')
            ->assertNotified()
            ->assertHasNoErrors();

        assertDatabaseHas(User::class, [
            'id' => $this->user->id,
            'preferences->appearance' => 'dark',
        ]);
    });

    test('appearance is required', function () {
        livewire(MyAccount::class)
            ->set('form.appearance', '')
            ->call('save')
            ->assertHasErrors(['form.appearance' => 'required']);
    });
});

describe('pronouns', function () {
    test('a user can update to custom pronouns', function () {
        livewire(MyAccount::class)
            ->set('form.pronouns', 'other')
            ->set('form.pronounSubject', 'xe')
            ->set('form.pronounObject', 'xem')
            ->call('save')
            ->assertHasNoErrors()
            ->assertNotified();

        assertDatabaseHas(User::class, [
            'id' => $this->user->id,
            'pronouns->value' => 'other',
            'pronouns->subject' => 'xe',
            'pronouns->object' => 'xem',
        ]);
    });

    test('a user can update to no pronouns', function () {
        livewire(MyAccount::class)
            ->set('form.pronouns', 'none')
            ->call('save')
            ->assertHasNoErrors()
            ->assertNotified();

        assertDatabaseHas(User::class, [
            'id' => $this->user->id,
            'pronouns->value' => 'none',
            'pronouns->subject' => null,
            'pronouns->object' => null,
        ]);
    });

    test('subject and object are automatically set when pronoun value changes', function () {
        $component = livewire(MyAccount::class);

        $component->assertSet('form.pronouns', 'female')
            ->assertSet('form.pronounSubject', 'she')
            ->assertSet('form.pronounObject', 'her');

        $component->set('form.pronouns', 'male')
            ->assertSet('form.pronounSubject', 'he')
            ->assertSet('form.pronounObject', 'him');

        $component->set('form.pronouns', 'neutral')
            ->assertSet('form.pronounSubject', 'they')
            ->assertSet('form.pronounObject', 'them');

        $component->set('form.pronouns', 'other')
            ->assertSet('form.pronounSubject', null)
            ->assertSet('form.pronounObject', null);
    });

    test('subject is required when pronouns is other', function () {
        livewire(MyAccount::class)
            ->set('form.pronouns', 'other')
            ->set('form.pronounSubject', '')
            ->set('form.pronounObject', 'xem')
            ->call('save')
            ->assertHasErrors(['form.pronounSubject']);
    });

    test('object is required when pronouns is other', function () {
        livewire(MyAccount::class)
            ->set('form.pronouns', 'other')
            ->set('form.pronounSubject', 'xe')
            ->set('form.pronounObject', '')
            ->call('save')
            ->assertHasErrors(['form.pronounObject']);
    });
});

describe('content rating thresholds', function () {
    test('a user can update language content rating threshold', function () {
        livewire(MyAccount::class)
            ->set('form.languageContentRatingWarningThreshold', ContentRatingValue::Level2)
            ->call('save')
            ->assertHasNoErrors()
            ->assertNotified();

        assertDatabaseHas(User::class, [
            'id' => $this->user->id,
            'preferences->languageContentRatingWarningThreshold' => '2',
        ]);
    });

    test('a user can update sex content rating threshold', function () {
        livewire(MyAccount::class)
            ->set('form.sexContentRatingWarningThreshold', ContentRatingValue::Level2)
            ->call('save')
            ->assertHasNoErrors()
            ->assertNotified();

        assertDatabaseHas(User::class, [
            'id' => $this->user->id,
            'preferences->sexContentRatingWarningThreshold' => '2',
        ]);
    });

    test('a user can update violence content rating threshold', function () {
        livewire(MyAccount::class)
            ->set('form.violenceContentRatingWarningThreshold', ContentRatingValue::Level2)
            ->call('save')
            ->assertHasNoErrors()
            ->assertNotified();

        assertDatabaseHas(User::class, [
            'id' => $this->user->id,
            'preferences->violenceContentRatingWarningThreshold' => '2',
        ]);
    });
});

describe('profile photo', function () {
    test('a user can set a cropped profile photo', function () {
        $component = livewire(MyAccount::class);

        expect($component->form->croppedImage)->toBeNull();

        $component->dispatch('croppedImageReady', 'path/to/cropped-image.jpg');

        expect($component->form->croppedImage)->toBe('path/to/cropped-image.jpg');
    });

    test('a cropped profile photo is uploaded when saving account', function () {
        Storage::fake('public');

        $fakePath = 'temp/cropped-avatar.jpg';
        Storage::disk('public')->put($fakePath, 'fake-image-content');

        livewire(MyAccount::class)
            ->dispatch('croppedImageReady', $fakePath)
            ->call('save')
            ->assertHasNoErrors()
            ->assertNotified();

        $this->user->refresh();
        expect($this->user->getFirstMedia('avatar'))->not->toBeNull();
    });
})->todo();

describe('update password', function () {
    test('a user can update their password', function () {
        assertTrue(Hash::check('secret', $this->user->password));

        livewire(MyAccount::class)
            ->set('form.currentPassword', 'secret')
            ->set('form.newPassword', 'password')
            ->set('form.newPasswordConfirmation', 'password')
            ->call('save')
            ->assertNotified()
            ->assertHasNoErrors();

        assertFalse(Hash::check('secret', $this->user->password));
        assertTrue(Hash::check('password', $this->user->password));
    });

    test('password fields are cleared after successful save', function () {
        livewire(MyAccount::class)
            ->set('form.currentPassword', 'secret')
            ->set('form.newPassword', 'new-password')
            ->set('form.newPasswordConfirmation', 'new-password')
            ->call('save')
            ->assertHasNoErrors()
            ->assertNotified()
            ->assertSet('form.currentPassword', null)
            ->assertSet('form.newPassword', null)
            ->assertSet('form.newPasswordConfirmation', null);
    });

    test('current password is required when changing password', function () {
        livewire(MyAccount::class)
            ->set('form.newPassword', 'new-password')
            ->set('form.newPasswordConfirmation', 'new-password')
            ->call('save')
            ->assertHasErrors(['form.currentPassword']);
    });

    test('current password must be correct', function () {
        livewire(MyAccount::class)
            ->set('form.currentPassword', 'wrong-password')
            ->set('form.newPassword', 'new-password')
            ->set('form.newPasswordConfirmation', 'new-password')
            ->call('save')
            ->assertHasErrors(['form.currentPassword' => 'current_password']);
    });

    test('password confirmation must match new password', function () {
        livewire(MyAccount::class)
            ->set('form.currentPassword', 'secret')
            ->set('form.newPassword', 'new-password')
            ->set('form.newPasswordConfirmation', 'different-new-password')
            ->call('save')
            ->assertHasErrors(['form.newPasswordConfirmation']);
    });
});
