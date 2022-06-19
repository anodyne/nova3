<?php

declare(strict_types=1);

namespace Nova\Posts\Livewire\Concerns;

use Illuminate\Support\Collection;

trait HasAuthors
{
    public mixed $characters;

    public mixed $users;

    public function mountHasAuthors(): void
    {
        $this->characters = $this->post->characterAuthors;
        $this->users = $this->post->userAuthors;
    }

    public function authorsUpdated(...$args): void
    {
        [$characters, $users] = $args;

        $this->characters = explode(',', $characters);
        $this->users = explode(',', $users);
    }
}
