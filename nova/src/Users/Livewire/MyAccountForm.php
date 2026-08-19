<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Nova\Stories\Enums\ContentRatingValue;
use Nova\Users\Actions\UploadUserAvatar;
use Nova\Users\Data\PronounsData;
use Nova\Users\Enums\Appearance;
use Nova\Users\Models\User;

class MyAccountForm extends Form
{
    #[Validate]
    public string $name;

    #[Validate]
    public string $email;

    #[Validate]
    public ?string $currentPassword = null;

    #[Validate]
    public ?string $newPassword = null;

    #[Validate]
    public ?string $newPasswordConfirmation = null;

    #[Validate]
    public string $pronouns;

    #[Validate]
    public ?string $pronounSubject = null;

    #[Validate]
    public ?string $pronounObject = null;

    #[Validate]
    public string $timezone;

    public string $imagePath;

    public ContentRatingValue $languageContentRatingWarningThreshold;

    public ContentRatingValue $sexContentRatingWarningThreshold;

    public ContentRatingValue $violenceContentRatingWarningThreshold;

    #[Validate]
    public Appearance $appearance;

    public ?string $croppedImage = null;

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email'],
            'currentPassword' => ['nullable', 'required_with:newPassword', 'current_password'],
            'newPassword' => ['sometimes'],
            'newPasswordConfirmation' => ['required_with:newPassword', 'same:newPassword'],
            'pronounSubject' => ['required_if:pronouns,other'],
            'pronounObject' => ['required_if:pronouns,other'],
            'timezone' => ['required'],
            'appearance' => ['required', Rule::enum(Appearance::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'passwordConfirmation.same' => 'The password confirmation field must match the password field',
        ];
    }

    public function setAccount(User $user): void
    {
        $this->name = $user->name;
        $this->email = $user->email;

        $this->pronouns = $user->pronouns->value;
        $this->pronounSubject = $user->pronouns->subject;
        $this->pronounObject = $user->pronouns->object;

        $this->appearance = $user->preferences->appearance ?? Appearance::Light;

        $this->timezone = $user->preferences->timezone ?? 'UTC';

        $this->languageContentRatingWarningThreshold = $user->preferences->languageContentRatingWarningThreshold ?? ContentRatingValue::Game;
        $this->sexContentRatingWarningThreshold = $user->preferences->sexContentRatingWarningThreshold ?? ContentRatingValue::Game;
        $this->violenceContentRatingWarningThreshold = $user->preferences->violenceContentRatingWarningThreshold ?? ContentRatingValue::Game;
    }

    public function setProfilePhoto(?string $path): void
    {
        $this->croppedImage = $path;
    }

    public function save(): void
    {
        $this->validate();

        $data = array_merge($this->only('name', 'email'), [
            'pronouns' => PronounsData::from(
                value: $this->pronouns,
                subject: $this->pronounSubject,
                object: $this->pronounObject,
            ),
        ]);

        if (filled($this->newPassword)) {
            $data['password'] = $this->newPassword;
        }

        $data['preferences'] = $this->only([
            'timezone',
            'appearance',
            'languageContentRatingWarningThreshold',
            'sexContentRatingWarningThreshold',
            'violenceContentRatingWarningThreshold',
        ]);

        /** @var User $user */
        $user = Auth::user();

        $user->update($data);

        /**
         * We use Storage::path() here to ensure we can add the temporary image
         * to Media Library.
         */
        $path = ! is_null($this->croppedImage)
            ? Storage::disk('public')->path($this->croppedImage)
            : null;

        UploadUserAvatar::run($user, $path);

        $this->reset('currentPassword', 'newPassword', 'newPasswordConfirmation');
    }

    public function updatedPronouns(string $value): void
    {
        $this->pronounSubject = PronounsData::getSubjectPronouns($value, null);
        $this->pronounObject = PronounsData::getObjectPronouns($value, null);
    }
}
