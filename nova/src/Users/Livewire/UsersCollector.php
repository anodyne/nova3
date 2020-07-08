<?php

namespace Nova\Users\Livewire;

use Livewire\Component;

class UsersCollector extends Component
{
    public $users;

    public $userIds;

    protected $listeners = ['userSelected' => 'handleUserSelected'];

    public function addUser($index)
    {
        $newIndex = $index + 1;

        $this->users[$newIndex]['id'] = null;
    }

    public function handleUserSelected($userId, $index)
    {
        $this->users[$index]['id'] = $userId;

        $this->updateUserIds();
    }

    public function removeUser($index)
    {
        unset($this->users[$index]);

        $this->users = array_values($this->users);

        $this->updateUserIds();
    }

    public function updateUserIds()
    {
        $this->userIds = collect($this->users)
            ->filter(function ($user) {
                return $user['id'] !== null;
            })
            ->implode('id', ',');
    }

    public function mount($users = null)
    {
        if ($users === null) {
            $this->users[0]['id'] = null;
        } else {
            $this->users = collect(explode(',', $users))
                ->map(function ($user) {
                    return ['id' => $user];
                })
                ->toArray();

            $this->updateUserIds();
        }
    }

    public function render()
    {
        return view('livewire.users.collector');
    }
}
