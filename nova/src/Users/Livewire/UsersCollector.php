<?php

declare(strict_types=1);

namespace Nova\Users\Livewire;

use Livewire\Component;

class UsersCollector extends Component
{
    public $users;

    protected $listeners = ['userSelected' => 'handleUserSelected'];

    public function addUser($index)
    {
        $newIndex = $index + 1;

        $this->users[$newIndex] = [
            'id' => null,
            'primary' => false,
        ];
    }

    public function handleUserSelected($userId, $index)
    {
        $this->users[$index] = [
            'id' => $userId,
            'primary' => false,
        ];
    }

    public function removeUser($index)
    {
        unset($this->users[$index]);

        $this->users = array_values($this->users);
    }

    public function mount($users = null, $primaryCharacters = [], $character = null)
    {
        if ($users === null || (is_array($users) && count($users) === 0)) {
            $this->users[0] = [
                'id' => null,
                'primary' => false,
            ];
        } else {
            $this->users = collect($users)
                ->map(function ($user) use ($character, $primaryCharacters) {
                    return [
                        'id' => $user,
                        'primary' => ($character === null)
                            ? in_array($user, $primaryCharacters)
                            : $character->primaryUsers->where('id', $user)->count() > 0,
                    ];
                })
                ->toArray();
        }
    }

    public function render()
    {
        return view('livewire.users.collector');
    }
}
