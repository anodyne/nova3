<?php

declare(strict_types=1);

namespace Nova\Ranks\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Auth\Authenticatable;
use Nova\Ranks\Models\RankItem;

class RankItemPolicy
{
    use HandlesAuthorization;

    public function create(Authenticatable $authenticatable): Response
    {
        return $authenticatable->isAbleTo('rank.create')
            ? $this->allow()
            : $this->deny();
    }

    public function delete(Authenticatable $authenticatable, RankItem $name): Response
    {
        return $this->deleteAny($authenticatable);
    }

    public function deleteAny(Authenticatable $authenticatable): Response
    {
        return $authenticatable->isAbleTo('rank.delete')
            ? $this->allow()
            : $this->deny();
    }

    public function duplicate(Authenticatable $authenticatable, RankItem $name): Response
    {
        return $authenticatable->isAbleTo('rank.create') && $authenticatable->isAbleTo('rank.update')
            ? $this->allow()
            : $this->deny();
    }

    public function forceDelete(Authenticatable $authenticatable, RankItem $name): Response
    {
        return $this->denyWithStatus(418);
    }

    public function restore(Authenticatable $authenticatable, RankItem $name): Response
    {
        return $this->denyWithStatus(418);
    }

    public function update(Authenticatable $authenticatable, RankItem $name): Response
    {
        return $authenticatable->isAbleTo('rank.update')
            ? $this->allow()
            : $this->deny();
    }

    public function view(Authenticatable $authenticatable, RankItem $name): Response
    {
        return $authenticatable->isAbleTo('rank.view')
            ? $this->allow()
            : $this->deny();
    }

    public function viewAny(Authenticatable $authenticatable): Response
    {
        return $authenticatable->isAbleTo('rank.*')
            ? $this->allow()
            : $this->deny();
    }
}
