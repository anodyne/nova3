<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Nova\Users\Data\PronounsData;
use Nova\Users\Models\User;

class MyAccountInfoForm extends Form
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
    public ?string $pronounPossessive = null;

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email'],
            'currentPassword' => ['required_with:form.newPassword', 'current_password'],
            'newPassword' => ['sometimes'],
            'newPasswordConfirmation' => ['required_with:form.newPassword', 'same:newPassword'],
            'pronounSubject' => ['required_if:form.pronouns,other'],
            'pronounObject' => ['required_if:form.pronouns,other'],
            'pronounPossessive' => ['required_if:form.pronouns,other'],
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
        $this->pronounPossessive = $user->pronouns->possessive;
    }

    public function save(): void
    {
        $this->validate();

        $data = array_merge($this->only('name', 'email'), [
            'pronouns' => PronounsData::from([
                'value' => $this->pronouns,
                'subject' => $this->pronounSubject,
                'object' => $this->pronounObject,
                'possessive' => $this->pronounPossessive,
            ]),
        ]);

        if (filled($this->newPassword)) {
            $data['password'] = Hash::make($this->newPassword);
        }

        auth()->user()->update($data);

        $this->reset('currentPassword', 'newPassword', 'newPasswordConfirmation');
    }
}
