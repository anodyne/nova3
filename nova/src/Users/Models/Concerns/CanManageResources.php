<?php

declare(strict_types=1);

namespace Nova\Users\Models\Concerns;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait CanManageResources
{
    public function canManage(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->isAbleTo('department.*')
                || $this->isAbleTo('rank.*')
                || $this->isAbleTo('role.*')
                || $this->isAbleTo('theme.*')
                || $this->isAbleTo('user.*')
        );
    }

    public function canManageUsers(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->isAbleTo('user.*')
                || $this->isAbleTo('role.*')
        );
    }

    public function canManageForms(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->isAbleTo('form.*')
                || $this->isAbleTo('form-submission.*')
        );
    }

    public function canManageSystem(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->isAbleTo('theme.*')
                || $this->isAbleTo('menu.*')
                || $this->isAbleTo('system.*')
                || $this->isAbleTo('addon.*')
        );
    }

    public function canWrite(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->isAbleTo('post.*')
                || $this->isAbleTo('story.*')
                || $this->isAbleTo('post-type.*')
        );
    }

    public function canManageStorytelling(): Attribute
    {
        return new Attribute(
            get: fn (): bool => $this->isAbleTo('post.*')
                || $this->isAbleTo('story.*')
                || $this->isAbleTo('post-type.*')
        );
    }
}
